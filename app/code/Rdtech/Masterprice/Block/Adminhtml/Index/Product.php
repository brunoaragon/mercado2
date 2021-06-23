<?php

namespace Rdtech\Masterprice\Block\Adminhtml\Index;

use \Rdtech\Masterprice\Helper\Data;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\ObjectManager;

class Product extends \Magento\Backend\Block\Widget\Container
{
    protected $resourceConnection;

    public function __construct(\Magento\Backend\Block\Widget\Context $context, array $data = [], Data $helperData, ResourceConnection $resourceConnection)
    {
        parent::__construct($context, $data);
        $this->resourceConnection = $resourceConnection;
        $this->_helperData = $helperData;
    }

    public function getProducts()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $connection = $this->resourceConnection->getConnection();
        $table = $connection->getTableName('productpending');
        $table_product = $connection->getTableName('catalog_product_entity');

        $query = "select * from " . $table . " p left join ". $table_product ." cpe on cpe.sku = p.sku where cpe.sku is null limit 50";       
        //$query = "SELECT *, (select count(sku) from catalog_product_entity e where e.sku like p.sku) as exist FROM " . $table. " p";
        $result = $connection->fetchAll($query);

        return $result;
    }
}
