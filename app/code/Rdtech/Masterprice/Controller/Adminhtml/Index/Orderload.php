<?php

namespace Rdtech\Masterprice\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Orderload extends \Magento\Backend\App\Action
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

        $order_collection = $objectManager->create('Magento\Sales\Model\Order')
            ->getCollection()
            ->addAttributeToFilter('status', array('nin' => array('complete','canceled','closed','fraud')));
        
        foreach($order_collection as $_order){
            $orderItems = $_order->getAllItems();    
            $checked = true;        
            foreach($orderItems as $_item){
                if($_item->getQtyShipped() == '0'){
                    $checked = false;    
                }
            }

            if($_order->getStatus() == 'aguardando_entrega'){
                $__style= "background: #e7f6e6";
            } else if($_order->getStatus() != 'pending'){
                $__style= "background: #e8fbff";
            } else {
                $__style= "";
            }
        ?>        
        <div class="order_item" style="<?= $__style ?>">            
            <div class="m2n-loading loading-<?= $_order->getId() ?>"><i style="font-size: 20px; color: #666; line-height: 88px;" class="fa fa-spinner fa-pulse"></i></div>

            <div class="order_id">
                <a target="_blank" href="/admin/sales/order/view/order_id/<?= $_order->getId() ?>">#<?= $_order->getIncrementId() ?></a>
                <input type="hidden" id="products_checked-<?= $_order->getId() ?>" class="products_checked" value="<?= $checked ?>">
            </div>

            <div class="order_info">     
                <div class="order_date">
                    <span><?= date("d/m/Y H:i:s", strtotime($_order->getCreatedAt())); ?></span>
                </div>  
                <div class="order_status order_status-<?= $_order->getId() ?>">
                    <span><?= $this->getStep($_order->getStatus()) ?></span> <?= $checked == true ? '<i style="color: #78c524;" class="fa fa-check"></i>' : '' ?>
                </div>   
                <div class="order_status">
                    <?php
                    $storeName = \Magento\Framework\App\ObjectManager::getInstance()
                    ->get(\Magento\Store\Model\StoreManagerInterface::class)
                    ->getStore($_order->getStoreId())
                    ->getName();
                    ?>
                    <span><?= $storeName ?></span>

                    <input class="order_store_id" type="hidden" value="<?= $_order->getStoreId() ?>">
                </div>                 
            </div>

            <div class="order_info"> 
                <div class="order_shipping">
                    <?php
                    $shipping = str_replace(' - Free','',$_order->getShippingDescription());
                    $shipping = str_replace(' - Fixed','',$shipping);
                    ?>
                    <span><?= $shipping ?></span>
                </div>   

                <div class="order_billing">
                    <?php        
                    $payment = $_order->getPayment();
                    $method = $payment->getMethodInstance();
                    $methodTitle = $method->getTitle();
                    ?>
                    <span><?= $methodTitle ?></span>
                </div>  
                
                <div class="order_price">
                    <span>R$<?= number_format($_order->getGrandTotal(),2,',','.') ?></span>
                </div>                
            </div>

            <div class="customer_info">
                <div class="order_name">
                    <span><?= $_order->getCustomerFirstname() ?> <?= $_order->getCustomerLastname() ?></span>
                </div>
                <div class="order_email">
                    <span><?= $_order->getCustomerEmail() ?></span>
                </div>   
                <div class="order_email">
                    <?php 
                    $phone = null;
                    if($_order->getShippingAddress()){
                        $phone = $_order->getShippingAddress()->getTelephone();
                    }                    
                    ?>
                    <span><?= $phone ?></span>
                </div>               
            </div>

            <div class="order_progress">
                <button type="button" onclick="cancelOrder(<?= $_order->getId() ?>)" class="btn-order-cancel">Cancelar Pedido</button>
                <button style="<?= $_order->getStatus() == 'aguardando_entrega' ? 'background:#5dc156 !important' : '' ?>" type="button" onclick="nextStep(<?= $_order->getId() ?>,'<?= $_order->getStatus() ?>','<?= $_order->getShippingMethod() ?>')" class="btn-order-next"><?= $this->getStepLabel($_order->getStatus()) ?></button>
            </div>            
            
        </div>
        <?php
        }        
    }

    function getStepLabel($step){
        if($step == 'pending'){
            return "Aprovar Pedido";
        } else if($step == 'aguardando_separacao'){
            return "Em Separação";
        } else if($step == 'separacao'){
            return "Pronto para a entrega";
        } else if($step == 'aguardando_entrega'){
            return "Pedido Entregue/Concluído";
        }
        
        return "Avançar";
    }

    function getStep($step){
        if($step == 'pending'){
            return "Aguardando Aprovação";
        } else if($step == 'aguardando_separacao'){
            return "Aguardando Separação";
        } else if($step == 'separacao'){
            return "Em Separação";
        } else if($step == 'aguardando_entrega'){
            return "Aguardando Entrega";
        } else if($step == 'complete'){
            return "Pedido Entregue";
        }

        return $step;
    }
}
