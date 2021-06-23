<?php

namespace Rdtech\Masterprice\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Ordercancel extends \Magento\Backend\App\Action
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
        $order_id = $_POST['order_id'];

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $_order = $objectManager->create('Magento\Sales\Model\Order')->load($order_id);
        
        $status_new = "canceled";
        $status_msg = "Seu pedido foi cancelado";

        $_order->setStatus($status_new);
        $_order->save();

        $orderCommentSender = $this->_objectManager->create('Magento\Sales\Model\Order\Email\Sender\OrderCommentSender');
        $orderCommentSender->send($_order, true, $status_msg);
    }

}
