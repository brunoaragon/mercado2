<?php

namespace Rdtech\Masterprice\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Orderseparate extends \Magento\Backend\App\Action
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
        $order_collection = $objectManager->create('Magento\Sales\Model\Order')->load($order_id);

        $orderItems = $order_collection->getAllItems();
        ?>
        <div class="s_header">
            <div class="s_order_id">
                #<?= $order_collection->getIncrementId() ?>
            </div>
            <div class="s_close" onclick="jQuery(this).parent().parent().hide()">
                <i class="fa fa-times"></i>
            </div>
        </div>

        <div id="s_order_items">
            <div id="s_barcode_enter">
                <input type="text" id="s_barcode_input">
                <i style="float: right; font-size: 18px; margin-right: -25px; margin-top: 8px;" class="fa fa-barcode"></i>
                <span onclick="productSelectAll()" style="float: right; margin-right: 40px; margin-top: 4px;cursor: pointer; font-weight: 600;">Selecionar todos</span>
            </div>

            <div class="s_order_item_head">           
                <div class="s_item_name">
                    <span>Produto</span>
                </div>
                <div class="s_item_sku">
                    <span>Código de Barras</span>
                </div>
                <div class="s_item_qtd">
                    <span>Quantidade</span>
                </div>               
            </div>      

            <?php
            foreach($orderItems as $_item){
                $product = $_item->getProduct();
            ?>  
            <div class="s_order_item">           
                <div class="s_item_name">
                    <span><img style="width: 49px; position: absolute; margin-left: -76px; margin-top: -15px;opacity: 0.8;" src="https://mercadonanuvem.s3-sa-east-1.amazonaws.com/webp/<?= $_item->getSku() ?>.webp"> <?= $_item->getName() ?></span>
                </div>
                <div class="s_item_sku">
                    <span><?= $_item->getSku() ?></span>
                </div>
                <div class="s_item_qtd">
                    <span><?= number_format($_item->getQtyOrdered(),3,',','.') ?></span>
                </div>
                <div class="s_item_checked">
                    <div for="item_<?= $_item->getId() ?>" onclick="checkProducts()">
                        <input type="checkbox" id="item_<?= $_item->getId() ?>" name="scales" <?= $_item->getQtyShipped() > 0 ? 'checked' : '' ?> >
                        <label for="item_<?= $_item->getId() ?>">Produto Separado</label>
                    </div>                
                </div>
            </div>       
            <?php
            }      
            ?>
        </div>
        <div id="s_btn_check">
            <button type="button" disabled="disabled" class="product-check" onclick="saveCheckProducts(<?= $order_id ?>)">Produtos Separados</button>
        </div>   
        <?php
    }    
}
