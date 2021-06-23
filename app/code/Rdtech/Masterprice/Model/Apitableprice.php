<?php

namespace Rdtech\Masterprice\Model;

use \Rdtech\Masterprice\Api\ApitablepriceInterface;

class Apitableprice implements ApitablepriceInterface
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
    public function insertTablePrice()
    {
        $data = json_decode($this->request->getContent());

        $_description   = $data->description;
        $_code          = $data->code;
        $_validity_init = $data->validity_init;
        $_validity_end  = $data->validity_end;
        $_is_active     = $data->is_active;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $_collection = $objectManager->create('\Rdtech\Masterprice\Model\Pricetable')->getCollection()
            ->addFieldToFilter('code', $_code)
            ->load();

        if (count($_collection) > 0) {
            $_pricetable = $_collection->getFirstItem();

            $_pricetable->setDescription($_description);
            //$_pricetable->setCode($_code);
            $_pricetable->setValidityInit($_validity_init);
            $_pricetable->setValidityEnd($_validity_end);
            // $_pricetable->setErpCode('');
            $_pricetable->setIsActive($_is_active);
            $_pricetable->save();
        } else {
            $_pricetable = $objectManager->create('Rdtech\Masterprice\Model\Pricetable');

            $_pricetable->setDescription($_description);
            $_pricetable->setCode($_code);
            $_pricetable->setValidityInit($_validity_init);
            $_pricetable->setValidityEnd($_validity_end);
            $_pricetable->setErpCode('');
            $_pricetable->setIsActive($_is_active);
            $_pricetable->save();
        }
    }   
}
