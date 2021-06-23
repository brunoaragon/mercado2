<?php

namespace Rdtech\Masterprice\Controller\Adminhtml\Index;

use Rdtech\Masterprice\Model\Productpending;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Productdelete extends \Magento\Backend\App\Action
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
        $_product_id  = $_POST['id'];

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();       
        $_product_pending = $objectManager->create('\Rdtech\Masterprice\Model\Productpending')->load($_product_id);

        $_product_pending->delete();
    }
}
