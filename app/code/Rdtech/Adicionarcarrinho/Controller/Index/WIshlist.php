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

class Wishlist extends \Magento\Framework\App\Action\Action
{
    protected $request;
    protected $formKey;
    protected $product;
    protected $logger;
    protected $cart;
    protected $_storeManager;
    protected $wishlist;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Catalog\Model\Product $product,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Wishlist\Model\Wishlist $wishlist,
        array $data = []
    ) {
        parent::__construct($context);
        $this->formKey = $formKey;
        $this->cart = $cart;
        $this->product = $product;
        $this->_checkoutSession = $checkoutSession;
        $this->_storeManager = $storeManager;
        $this->wishlist = $wishlist;
    }

    public function execute()
    {
        $item_id = $_POST['item'];
        $status = $_POST['status'];

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->get('Magento\Customer\Model\Session');
        $customer_id = $customerSession->getCustomer()->getId(); 

        $wishlist_collection = $this->wishlist->loadByCustomerId($customer_id, true)->getItemCollection();

        foreach ($wishlist_collection as $item) {
            if($item->getId() == $item_id){
                $item->setDescription($status);
                $item->save();
            }
        }
    }
}
