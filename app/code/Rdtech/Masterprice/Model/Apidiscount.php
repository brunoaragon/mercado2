<?php

namespace Rdtech\Masterprice\Model;

use \Rdtech\Masterprice\Api\ApidiscountInterface;

class Apidiscount implements ApidiscountInterface
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
    public function insertDiscount()
    {
        $data = json_decode($this->request->getContent());

        $_product_id        = $data->product_id;
        $_code              = $data->code;
        $_store_id          = $data->store_id;
        $_percentage        = $data->percentage;
        $_category_id       = $data->category_id;
        $_price_table_id    = $data->price_table_id;
        $_customer_id       = $data->customer_id;
        $_date_from         = $data->date_from;
        $_date_to           = $data->date_to;
        $_is_active         = $data->is_active;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $_collection = $objectManager->create('\Rdtech\Masterprice\Model\Discount')->getCollection()
            ->addFieldToFilter('product_id', $_code)
            ->addFieldToFilter('customer_id', $_code)
            ->addFieldToFilter('store_id', $_code)
            ->load();

        if (count($_collection) > 0) {
            $_pricetable = $_collection->getFirstItem();

            //$_pricetable->setProductId($_product_id);
            //$_pricetable->setCode($_code);
            //$_pricetable->setStoreId($_store_id);
            $_pricetable->setPercentage($_percentage);
            //$_pricetable->setCategoryId($_category_id);
            //$_pricetable->setPriceTableId($_price_table_id);
            //$_pricetable->setCustomerId($_customer_id);
            $_pricetable->setDateFrom($_date_from);
            $_pricetable->setDateTo($_date_to);
            $_pricetable->setIsActive($_is_active);
            $_pricetable->save();
        } else {
            $_pricetable = $objectManager->create('Rdtech\Masterprice\Model\Discount');

            $_pricetable->setProductId($_product_id);
            $_pricetable->setCode($_code);
            $_pricetable->setStoreId($_store_id);
            $_pricetable->setPercentage($_percentage);
            $_pricetable->setCategoryId($_category_id);
            $_pricetable->setPriceTableId($_price_table_id);
            $_pricetable->setCustomerId($_customer_id);
            $_pricetable->setDateFrom($_date_from);
            $_pricetable->setDateTo($_date_to);
            $_pricetable->setIsActive($_is_active);
            $_pricetable->save();
        }
    }  
}
