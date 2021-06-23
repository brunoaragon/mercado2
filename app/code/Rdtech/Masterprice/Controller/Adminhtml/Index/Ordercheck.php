<?php

namespace Rdtech\Masterprice\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Ordercheck extends \Magento\Backend\App\Action
{
    protected $request;
    protected $_moduleFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
    }

    public function execute()
    {       
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order_collection = $objectManager->create('Magento\Sales\Model\Order')->load($_POST['order_id']);

        $orderItems = $order_collection->getAllItems();

        foreach($orderItems as $_item){
            $_item->setQtyShipped(1);
            $_item->save();
        }

        $order_collection->save();
    }    
}
