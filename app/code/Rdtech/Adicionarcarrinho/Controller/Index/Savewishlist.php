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

class Savewishlist extends \Magento\Framework\App\Action\Action
{
    protected $request;
    protected $formKey;
    protected $_wishlistRepository;
    protected $_productRepository;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Wishlist\Model\WishlistFactory $wishlistRepository,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        parent::__construct($context);
        $this->formKey = $formKey;
        $this->_wishlistRepository = $wishlistRepository;
        $this->_productRepository = $productRepository;
    }

    public function execute()
    {
        $product_id = $_POST['product_id'];

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->get('Magento\Customer\Model\Session');
        if ($customerSession->isLoggedIn()) {
            $customerSession = $objectManager->get('Magento\Customer\Model\Session');

            $customer_id = $customerSession->getCustomer()->getId();

            try {
                $product = $this->_productRepository->getById($product_id);
            } catch (NoSuchEntityException $e) {
                $product = null;
            }

            $wishlist = $this->_wishlistRepository->create()->loadByCustomerId($customer_id, true);

            $wishlist->addNewItem($product);
            $wishlist->save();

            echo "1";
        } else {
            echo "0";
        }
    }
}
