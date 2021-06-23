<?php

namespace Rdtech\Cashback\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $connection = $installer->getConnection();
        $salesOrder = $installer->getTable('sales_order');
        $connection->addColumn(
            $salesOrder,
            'cashback',
            ['type' => Table::TYPE_TEXT, 'visible' => false, 'comment' => 'Cashback']
        );
        $installer->endSetup();

        $installer = $setup;
        $installer->startSetup();
        $connection = $installer->getConnection();
        $salesOrder = $installer->getTable('sales_order');
        $connection->addColumn(
            $salesOrder,
            'cashback_used',
            ['type' => Table::TYPE_TEXT, 'visible' => false, 'comment' => 'Cashback Used']
        );
        $installer->endSetup();
    }
}
