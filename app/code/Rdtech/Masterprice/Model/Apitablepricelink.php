<?php

namespace Rdtech\Masterprice\Model;

use \Rdtech\Masterprice\Api\ApitablepricelinkInterface;

class Apitablepricelink implements ApitablepricelinkInterface
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
    public function insertTablePriceLink()
    {
        $data = json_decode($this->request->getContent());     

        $_store_id          = $data->store_id;
        $_price_table_id    = $data->price_table_id;
        $_customer_id       = $data->customer_id;
        $_customer_group_id = $data->customer_group_id;
        $_is_active         = $data->is_active;           

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $_pricetable = $objectManager->create('Rdtech\Masterprice\Model\Pricetablelink');

        $_pricetable->setStoreId($_store_id);
        $_pricetable->setPriceTableId($_price_table_id);
        $_pricetable->setCustomerId($_customer_id);
        $_pricetable->setCustomerGroupId($_customer_group_id);
        $_pricetable->setIsActive($_is_active);        
        $_pricetable->save();
    }
}
