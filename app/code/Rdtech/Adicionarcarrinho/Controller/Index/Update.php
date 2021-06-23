<?php

namespace Rdtech\Adicionarcarrinho\Controller\Index;

use Rdtech\Adicionarcarrinho\Model\Bargain;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use Magento\Checkout\Model\Sidebar;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Response\Http;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Json\Helper\Data;
use Magento\Checkout\Model\Cart;

class Update extends \Magento\Framework\App\Action\Action
{
    protected $request;
    protected $formKey;   
    protected $product;
    protected $logger;
    protected $cart;
    protected $_storeManager; 

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Catalog\Model\Product $product,        
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager, 
        array $data = []
    ) {
        parent::__construct($context);
        $this->formKey = $formKey;
        $this->cart = $cart;
        $this->product = $product;    
        $this->_checkoutSession = $checkoutSession;
        $this->_storeManager = $storeManager;      
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
            $quote_collection = $this->cart->getQuote()->getAllVisibleItems();

            foreach ($quote_collection as $_quote_item) {
                if($_quote_item->getProduct()->getId() == $product_id){
                    $itemData = [$_quote_item->getId() => ['qty' => $qtd]];
                    $this->cart->updateItems($itemData)->save();  
                }
            }            

            echo "1";
        } else {
            echo "0";
        }
    }
}
