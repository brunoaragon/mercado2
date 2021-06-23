<?php

namespace Rdtech\Adicionarcarrinho\Controller\Index;

use Rdtech\Adicionarcarrinho\Model\Bargain;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Save extends \Magento\Framework\App\Action\Action
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
        $product_id = $_POST['product_id'];
        $qtd = $_POST['qtd'];

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
        $currentStore = $storeManager->getStore();

        $StockState = $objectManager->get('\Magento\CatalogInventory\Api\StockStateInterface');
        $_quantity = $StockState->getStockQty($product_id, $currentStore->getWebsiteId());

        if ($_quantity >= $qtd) {
            $params = array(
                'form_key' => $this->formKey->getFormKey(),
                'product' => $product_id,
                'qty' => $qtd
            );

            $_product = $this->product->load($product_id);
            $this->cart->addProduct($_product, $params);
            $this->cart->save();

            echo "1";
        } else {
            echo "0";
        }
    }
}
