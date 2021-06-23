<?php

namespace Rdtech\Masterprice\Controller\Adminhtml\Index;

use Rdtech\Masterprice\Model\Productpending;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Productexportremove extends \Magento\Backend\App\Action
{
    protected $request;
    protected $_moduleFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Rdtech\Masterprice\Model\ProductpendingFactory $moduleFactory,
        \Magento\Framework\HTTP\Client\Curl $curl
    ) {
        $this->_moduleFactory = $moduleFactory;
        parent::__construct($context);
        $this->curl = $curl;
    }

    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $_product = $objectManager->create('Magento\Catalog\Model\Product')->load($_POST['id']);

        $_product->setExportPending(false); 
        $_product->save(); 
    }
}
