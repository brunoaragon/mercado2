<?php

namespace Rdtech\Store\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use Rdtech\Store\Helper\Data;

class Store extends \Magento\Framework\App\Action\Action
{
    protected $request;
    protected $formKey;   
    protected $cart;
    protected $product;
    protected $_helper;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Catalog\Model\Product $product,
        \Rdtech\Store\Helper\Data $helper,
        array $data = []
    ) {
        parent::__construct($context);
        $this->formKey = $formKey;
        $this->cart = $cart;
        $this->product = $product;  
        $this->_helper = $helper;    
    }

    public function execute()
    {
        $cep = $_POST['cep'];
        $store = $_POST['store'];

        $validation = $this->_helper->getValidateCep($cep,$store);

        echo $validation;
    }
}
