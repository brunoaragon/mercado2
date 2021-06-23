<?php

namespace Rdtech\Masterprice\Controller\Adminhtml\Index;

use Rdtech\Masterprice\Model\Productpending;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Productsave extends \Magento\Backend\App\Action
{
    protected $request;
    protected $_moduleFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Rdtech\Masterprice\Model\ProductpendingFactory $moduleFactory
    ) {
        $this->_moduleFactory = $moduleFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $_product_id        = $_POST['id'];
        $_sku               = $_POST['sku'];
        $_categories        = $_POST['categories'];
        $_shortdescription  = $_POST['shortdescription'];
        $_description       = $_POST['description'];
        $_name              = $_POST['name'];
        $_price             = $_POST['price'];

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        
        try{
            $_product_pending = $objectManager->create('\Rdtech\Masterprice\Model\Productpending')->load($_product_id);

            $_quantity   = 1;
            $_visibility = 4;            

            $_product = $objectManager->create('Magento\Catalog\Model\Product');
            $_product->setName($_name);
            $_product->setTypeId('simple');
            $_product->setAttributeSetId(4);
            $_product->setSku($_sku);
            $_product->setStatus(2);
            $_product->setShortDescription($_shortdescription);
            $_product->setDescription($_description);
            $_product->setWebsiteIds(array(1));
            $_product->setVisibility($_visibility);
            $_product->setPrice($_price);
            $_product->setCategoryIds($_categories);
            $_product->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'min_sale_qty' => 1,
                'max_sale_qty' => 9999,
                'is_in_stock' => 1,
                'qty' => $_quantity
            ));

            $_product->save();
            $_product_pending->delete();

            $productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
            $productObj = $productRepository->get($_sku);
            $productid = $productObj->getId();

            echo '/admin/catalog/product/edit/id/'.$productid;
        } catch (\Error $e) {
            echo '0';
        }
    }
}
