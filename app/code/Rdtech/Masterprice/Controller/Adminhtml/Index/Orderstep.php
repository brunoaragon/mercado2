<?php

namespace Rdtech\Masterprice\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Orderstep extends \Magento\Backend\App\Action
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
        $order_status = $_POST['order_status'];
        $order_shipping = $_POST['order_shipping'];

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $_order = $objectManager->create('Magento\Sales\Model\Order')->load($order_id);
        
        if($order_status == 'pending'){
            $status_new = "aguardando_separacao";
            $status_msg = "Seu pedido foi aprovado e esta aguardando a separação.";
        } else if($order_status == 'aguardando_separacao'){
            $status_new = "separacao";
            $status_msg = "Seu pedido esta em processo de separação.";
        } else if($order_status == 'separacao'){
            $status_new = "aguardando_entrega";

            if($order_shipping == 'flatrate_flatrate'){
                $status_msg = "Seu pedido esta pronto para a entrega";
            } else {
                $status_msg = "Seu pedido esta pronto para retirar";
            }            
        } else if($order_status == 'aguardando_entrega'){
            $status_new = "complete";

            if($order_shipping == 'flatrate_flatrate'){
                $status_msg = "Seu pedido foi entregue";
            } else {
                $status_msg = "Seu pedido foi retirado";
            } 
        }

        $_order->setStatus($status_new);
        $_order->save();

        $orderCommentSender = $this->_objectManager->create('Magento\Sales\Model\Order\Email\Sender\OrderCommentSender');
        $orderCommentSender->send($_order, true, $status_msg);
    }

}
