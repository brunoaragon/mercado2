<?php

namespace Rdtech\Adicionarcarrinho\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Datanascimento extends \Magento\Framework\App\Action\Action
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
        $_nascimento = $_POST['nascimento'];

        $year = substr($_nascimento,6,4);
        $month = substr($_nascimento,3,2);
        $day = substr($_nascimento,0,2);

        $_nascimento = $month."/".$day."/".$year;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->get('Magento\Customer\Model\Session');
        if ($customerSession->isLoggedIn()) {
            $customer_id = $customerSession->getCustomer()->getId();
            
            $_customer = $objectManager->create('Magento\Customer\Model\Customer')->load($customer_id);

            $_customer->setDob($_nascimento);
            $_customer->save();
        }
    }
}
