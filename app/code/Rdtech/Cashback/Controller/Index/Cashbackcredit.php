<?php

namespace Rdtech\Cashback\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Cashbackcredit extends \Magento\Framework\App\Action\Action
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
        \Rdtech\Cashback\Helper\Data $helper,
        array $data = []
    ) {
        parent::__construct($context);
        $this->formKey = $formKey;
        $this->cart = $cart;
        $this->product = $product;
        $this->helper = $helper;
    }

    public function execute()
    {
        $_credit = floatval($this->helper->getCashbackCredit());

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart');

        $subTotal = $cart->getQuote()->getSubtotal();

        if ($_credit > $subTotal) {
            $cashback_total = $subTotal;
        } else {
            $cashback_total = $_credit;
        }

        echo '-R$' . number_format($cashback_total, 2, '.', ',');
    }
}
