<?php

namespace Rdtech\Masterprice\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\ObjectManager;

class UpgradeData implements UpgradeDataInterface
{
    private $eavSetupFactory;
    private $attributeSetFactory;
    private $attributeSet;
    private $categorySetupFactory;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        CategorySetupFactory $categorySetupFactory,
        ResourceConnection $resourceConnection
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->categorySetupFactory = $categorySetupFactory;
        $this->resourceConnection = $resourceConnection;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.1') < 0) {
            $this->saveStatus('separacao', 'Em Separação');
            $this->saveStatus('aguardando_separacao', 'Aguardando Separação');
            $this->saveStatus('aguardando_entrega', 'Pronto para Entregar');
        }

        if (version_compare($context->getVersion(), '1.0.2') < 0) {
            $connection = $this->resourceConnection->getConnection();

            $table = $connection->getTableName('sales_order_status');

            $query = "UPDATE $table SET label = 'Aguardando Aprovação' WHERE status = 'pending'";
            $connection->query($query);
        }

        if (version_compare($context->getVersion(), '1.0.3') < 0) {
            $connection = $this->resourceConnection->getConnection();

            $table = $connection->getTableName('sales_order_status');

            $query = "UPDATE $table SET label = 'Pedido Finalizado' WHERE status = 'complete'";
            $connection->query($query);
        }

        if (version_compare($context->getVersion(), '1.0.4') < 0) {
            $connection = $this->resourceConnection->getConnection();

            $table = $connection->getTableName('sales_order_status');

            $query = "UPDATE $table SET label = 'Pedido Cancelado' WHERE status = 'canceled'";
            $connection->query($query);
        }

        if (version_compare($context->getVersion(), '1.0.5') < 0) {
            $installer = $setup;
            $installer->startSetup();

            $tablename = $setup->getTable('usersorder');
            if (!$installer->tableExists($tablename)) {
                $table = $installer->getConnection()->newTable(
                    $installer->getTable($tablename)
                )
                    ->addColumn(
                        'id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'nullable' => false,
                            'primary'  => true,
                            'unsigned' => true,
                        ],
                        'ID'
                    )
                    ->addColumn(
                        'username',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        ['nullable => false'],
                        'Username'
                    )
                    ->addColumn(
                        'password',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        [],
                        'Password'
                    )
                    ->addColumn(
                        'is_active',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        5,
                        [],
                        'Is Active'
                    )
                    ->setComment('Users');
                $installer->getConnection()->createTable($table);
            }

            $installer->endSetup();
        }

        if (version_compare($context->getVersion(), '1.0.6') < 0) {
            $installer = $setup;
            $installer->startSetup();

            $tablename = $setup->getTable('productpending');
            if (!$installer->tableExists($tablename)) {
                $table = $installer->getConnection()->newTable(
                    $installer->getTable($tablename)
                )
                    ->addColumn(
                        'id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'nullable' => false,
                            'primary'  => true,
                            'unsigned' => true,
                        ],
                        'ID'
                    )
                    ->addColumn(
                        'name',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        ['nullable => false'],
                        'Name'
                    )
                    ->addColumn(
                        'short_description',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        [],
                        'Short Description'
                    )
                    ->addColumn(
                        'description',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        555,
                        [],
                        'Description'
                    )
                    ->addColumn(
                        'categories',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        [],
                        'Categories'
                    )
                    ->addColumn(
                        'sku',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        55,
                        [],
                        'Sku'
                    )
                    ->addColumn(
                        'price',
                        \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                        '10,4',
                        ['nullable => true'],
                        'Price'
                    )
                    ->addColumn(
                        'store',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        [],
                        'Store'
                    )
                    ->setComment('Products Pending');
                $installer->getConnection()->createTable($table);
            }

            $installer->endSetup();
        }

        if (version_compare($context->getVersion(), '1.0.7') < 0) {
            $installer = $setup;
            $installer->startSetup();

            $setup->startSetup();
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'export_pending',
                [
                    'group' => 'General',
                    'type' => 'int',
                    'backend' => '',
                    'frontend' => '',
                    'label' => 'Exportação Pendente',
                    'input' => 'boolean',
                    'class' => '',
                    'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => false,
                    'default' => '0',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => false,
                    'unique' => false,
                    'apply_to' => ''
                ]
            );

            $installer->endSetup();
        }

        if (version_compare($context->getVersion(), '1.0.8') < 0) {
            $installer = $setup;
            $installer->startSetup();

            $tablename = $setup->getTable('stores');
            if (!$installer->tableExists($tablename)) {
                $table = $installer->getConnection()->newTable(
                    $installer->getTable($tablename)
                )
                    ->addColumn(
                        'id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'nullable' => false,
                            'primary'  => true,
                            'unsigned' => true,
                        ],
                        'ID'
                    )
                    ->addColumn(
                        'name',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        ['nullable => false'],
                        'Name'
                    )
                    ->addColumn(
                        'token',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        [],
                        'Token'
                    )
                    ->addColumn(
                        'url',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        555,
                        [],
                        'Url'
                    )
                    ->setComment('Stores');
                $installer->getConnection()->createTable($table);
            }

            $installer->endSetup();
        }

        if (version_compare($context->getVersion(), '1.0.9') < 0) {
            $installer = $setup;
            $installer->startSetup();

            $setup->startSetup();
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'produto_por_peso',
                [
                    'group' => 'General',
                    'type' => 'int',
                    'backend' => '',
                    'frontend' => '',
                    'label' => 'Vendido Por Peso',
                    'input' => 'boolean',
                    'class' => '',
                    'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => false,
                    'default' => '0',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => false,
                    'unique' => false,
                    'apply_to' => ''
                ]
            );

            $installer->endSetup();
        }

        if (version_compare($context->getVersion(), '1.0.10') < 0) {
            $installer = $setup;
            $installer->startSetup();

            $setup->startSetup();
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'produto_unidade_medida',
                [
                    'type' => 'text',
                    'backend' => '',
                    'frontend' => '',
                    'label' => 'Unidade de Medida',
                    'input' => 'text',
                    'class' => '',
                    'source' => '',
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => false,
                    'default' => '',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => false,
                    'unique' => false,
                    'apply_to' => '',
                    'note' => 'g = gramas / ml = miligramas'
                ]
            );

            $installer->endSetup();
        }

        if (version_compare($context->getVersion(), '1.0.11') < 0) {
            $installer = $setup;
            $installer->startSetup();

            $setup->startSetup();
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'produto_peso_unidade',
                [
                    'type' => 'text',
                    'backend' => '',
                    'frontend' => '',
                    'label' => 'Peso por Unidade',
                    'input' => 'text',
                    'class' => '',
                    'source' => '',
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => false,
                    'default' => '',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => false,
                    'unique' => false,
                    'apply_to' => ''
                ]
            );

            $installer->endSetup();
        }

        if (version_compare($context->getVersion(), '1.0.12') < 0) {
            $installer = $setup;
            $installer->startSetup();

            $setup->startSetup();
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'sku_proprio',
                [
                    'group' => 'General',
                    'type' => 'int',
                    'backend' => '',
                    'frontend' => '',
                    'label' => 'SKU Próprio',
                    'input' => 'boolean',
                    'class' => '',
                    'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => false,
                    'default' => '0',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => false,
                    'unique' => false,
                    'apply_to' => '',
                    'note' => 'Identificação própria da loja.'
                ]
            );

            $installer->endSetup();
        }

        if (version_compare($context->getVersion(), '1.0.13') < 0) {
            $installer = $setup;
            $installer->startSetup();

            $setup->startSetup();
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'sku_mnn',
                [
                    'type' => 'text',
                    'backend' => '',
                    'frontend' => '',
                    'label' => 'SKU (Mercado na Nuvem)',
                    'input' => 'text',
                    'class' => '',
                    'source' => '',
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => false,
                    'default' => '',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => false,
                    'unique' => true,
                    'apply_to' => ''
                ]
            );

            $installer->endSetup();
        }

        if (version_compare($context->getVersion(), '1.0.14') < 0) {
            $installer = $setup;
            $installer->startSetup();

            $tablename = $setup->getTable('cep');
            if (!$installer->tableExists($tablename)) {
                $table = $installer->getConnection()->newTable(
                    $installer->getTable($tablename)
                )
                    ->addColumn(
                        'id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'nullable' => false,
                            'primary'  => true,
                            'unsigned' => true,
                        ],
                        'ID'
                    )
                    ->addColumn(
                        'cidade',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        100,
                        ['nullable => false'],
                        'Cidade'
                    )
                    ->addColumn(
                        'logradouro',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        125,
                        ['nullable => false'],
                        'Logradouro'
                    )
                    ->addColumn(
                        'bairro',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        100,
                        ['nullable => false'],
                        'Bairro'
                    )
                    ->addColumn(
                        'cep',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        25,
                        ['nullable => false'],
                        'Cep'
                    )
                    ->addColumn(
                        'tp_logradouro',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        25,
                        ['nullable => false'],
                        'Tipo Logradouro'
                    )  
                    ->addColumn(
                        'uf',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        25,
                        ['nullable => false'],
                        'UF'
                    )                  
                    ->setComment('Cep');
                $installer->getConnection()->createTable($table);
            }

            $installer->endSetup();
        }

        if (version_compare($context->getVersion(), '1.0.15') < 0) {
            $installer = $setup;
            $installer->startSetup();

            $tablename = $setup->getTable('notification');
            if (!$installer->tableExists($tablename)) {
                $table = $installer->getConnection()->newTable(
                    $installer->getTable($tablename)
                )
                    ->addColumn(
                        'token',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        555,
                        [],
                        'Token'
                    )      
                    ->addColumn(
                        'customer_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        555,
                        [],
                        'Customer'
                    )                           
                    ->setComment('Notification Token');
                $installer->getConnection()->createTable($table);
            }

            $installer->endSetup();
        }

        if (version_compare($context->getVersion(), '1.0.16') < 0) {
            $installer = $setup;
            $installer->startSetup();

            $setup->startSetup();
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'maioridade',
                [
                    'group' => 'General',
                    'type' => 'int',
                    'backend' => '',
                    'frontend' => '',
                    'label' => 'Requer Maioridade',
                    'input' => 'boolean',
                    'class' => '',
                    'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => false,
                    'default' => '0',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => false,
                    'unique' => false,
                    'apply_to' => '',
                    'note' => 'Necessita informar data de nascimento (+18)'
                ]
            );

            $installer->endSetup();
        }

    }

    public function saveStatus($status_code, $status_label)
    {
        $connection = $this->resourceConnection->getConnection();

        $table = $connection->getTableName('sales_order_status');

        $tableColumn = ['status', 'label'];
        $tableData[] = [$status_code, $status_label];

        $connection->insertArray($table, $tableColumn, $tableData);
        $query = "INSERT IGNORE INTO $table VALUES ('$status_code', '$status_label')";
        $connection->query($query);

        $this->saveStatusState($status_code);
    }

    public function saveStatusState($status_code)
    {
        $connection = $this->resourceConnection->getConnection();

        $table = $connection->getTableName('sales_order_status_state');
        $tableColumn = ['status', 'state', 'is_default', 'visible_on_front'];
        $tableData[] = [$status_code, $status_code, 1, 1];

        $connection->insertArray($table, $tableColumn, $tableData);
        $query = "INSERT IGNORE INTO $table VALUES ('$status_code', '$status_code', 1, 1)";

        $connection->query($query);
    }
}
