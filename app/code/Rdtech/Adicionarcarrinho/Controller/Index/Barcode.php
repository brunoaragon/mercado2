<?php

namespace Rdtech\Adicionarcarrinho\Controller\Index;

use Rdtech\Adicionarcarrinho\Model\Bargain;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Barcode extends \Magento\Framework\App\Action\Action
{
    protected $request;
    protected $formKey;
    protected $cart;
    protected $product;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Catalog\Model\Product $product,
        array $data = []
    ) {
        parent::__construct($context);
        $this->formKey = $formKey;
        $this->cart = $cart;
        $this->product = $product;
    }

    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 

        $productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
        $productObj = $productRepository->get($_POST['sku']);
        
        $_product = $objectManager->get('Magento\Catalog\Api\ProductRepositoryInterface')->getById($productObj->getId());

?>
        <div class="item-barcode-loaded item-loaded-<?= $_product->getId() ?>">
            <div class="col-md-1" style="background: #fff !important;">
                <img src="https://mercadonanuvem.s3-sa-east-1.amazonaws.com/webp/<?= $_product->getSku(); ?>.webp">
            </div>
            <div class="col-md-6">
                <span><?= $_product->getName() ?></span>
            </div>
            <div class="col-md-1">
                <input type="text" class="qtd-<?= $_product->getId() ?>" value="1">
            </div>
            <div class="col-md-2">
                <button onclick="barcodeAddToCart(<?= $_product->getId() ?>)" type="button" class="addtocart"><i class="fa fa-shopping-cart"></i></button>
            </div>
            <div class="col-md-2">
                <button type="button" class="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
<?php
    }
}
