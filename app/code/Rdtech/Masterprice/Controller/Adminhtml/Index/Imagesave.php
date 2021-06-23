<?php

namespace Rdtech\Masterprice\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Imagesave extends \Magento\Backend\App\Action
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


        if(!isset($_SESSION['min_product_id_loaded']) || $_SESSION['min_product_id_loaded'] < 1){
             $_SESSION['min_product_id_loaded'] = 0;
        }        
        
        $productCollectionFactory = $objectManager->get('\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collection = $productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('external_image', array('null' => true));
        $collection->addAttributeToFilter('entity_id', array('gt' => $_SESSION['min_product_id_loaded']));
        $collection->setPageSize(1000); 
      
        foreach ($collection as $product) { 
        ?>
            <div class="product-loaded sku-<?= $product->getSku() ?>" id="sku-<?= $product->getSku() ?>" style="width: 100%;padding: 0 10px;display:flex;border-bottom:1px solid #ddd;height: 45px;">
                <div class="product-name-img" style="width:calc(100% - 370px);padding-top: 11px;font-weight: 600;">
                    <span><?= $product->getId() ?>. <?= $product->getName() ?></span>
                </div>
                <div style="width:120px;padding-top: 10px;">
                    <span class="ico-load"><i class="fa fa-spinner fa-spin"></i></span>
                    <span class="sku-load"><?= $product->getSku() ?></span>
                </div>
                <div style="width:50px;padding-top: 10px;">                                     
                    <img onerror="imgError(this)" onload="imgLoad(this)" style="height:20px;width:auto" src="https://mercadonanuvem.s3-sa-east-1.amazonaws.com/webp/<?= $product->getSku() ?>.webp">
                </div>  
                <div class="remove-pdt" style="width:100px;padding-top: 10px;">                    
                    <span style="color: #555; cursor: pointer;">Procurando</span>
                </div>  
                <div style="width:100px">
                    <button style="width: 100%;" class="importImg" onclick="importImage(<?= $product->getSku() ?>)" disabled="disabled" type="button">Pendente</button>  
                </div>                
            </div>            
        <?php  
            $last_id = $product->getId();
        } 
        ?>        
        <script>
            jQuery('.count-loaded').val(parseInt(jQuery('.count-loaded').val()) + <?= count($collection) ?>);
        </script>
        <?php        
        $_SESSION['min_product_id_loaded'] = $last_id;
    }
}
