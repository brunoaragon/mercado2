<?php

namespace Rdtech\Master\Model;

use \Rdtech\Master\Api\ProductpendingInterface;

class Productpending implements ProductpendingInterface
{
    /**
     * @var \Magento\Customer\Api\Data\AddressInterfaceFactory
     */
    protected $addressFactory;
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;
    /**
     * CustomerAddress constructor.
     * @param \Magento\Customer\Model\AddressFactory $addressFactory
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        \Magento\Customer\Model\AddressFactory $addressFactory,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->addressFactory = $addressFactory;
        $this->request = $request;
    }
    public function insertProduct()
    {
        $data = json_decode($this->request->getContent());

        $_name              = $data->name;
        $_sku               = $data->sku;
        $_price             = $data->price;
        $_description       = $data->description;
        $_shortdescription  = $data->shortdescription;
        $_categories        = $data->categories;
        $_store             = $data->store;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $_product = $objectManager->create('Rdtech\Masterprice\Model\Productpending');
        $_product->setName($_name);
        $_product->setSku($_sku);
        $_product->setShortDescription($_shortdescription);
        $_product->setDescription($_description);
        $_product->setPrice($_price);       
        $_product->setCategories($_categories);  
        $_product->setStore($_store);  
       
        $_product->save();
    }
}
