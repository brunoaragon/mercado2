<?php

namespace Rdtech\Masterprice\Model;

use \Rdtech\Masterprice\Api\ApitablepriceproductInterface;

class Apitablepriceproduct implements ApitablepriceproductInterface
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
    public function insertTablePriceProduct()
    {
        $data = json_decode($this->request->getContent());     

        $_product_id        = $data->product_id;
        $_price_table_id    = $data->price_table_id;
        $_price             = $data->price;        

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $_collection = $objectManager->create('\Rdtech\Masterprice\Model\Pricetableproduct')->getCollection()
            ->addFieldToFilter('product_id',$_product_id)
            ->addFieldToFilter('price_table_id',$_price_table_id)
            ->load();

        if(count($_collection) > 0){
            $_pricetable = $_collection->getFirstItem();

            $_pricetable->setProductId($_product_id);
            $_pricetable->setPriceTableId($_price_table_id);
            $_pricetable->setPrice($_price);   
            $_pricetable->save();
        } else {
            $_pricetable = $objectManager->create('Rdtech\Masterprice\Model\Pricetableproduct');

            $_pricetable->setProductId($_product_id);
            $_pricetable->setPriceTableId($_price_table_id);
            $_pricetable->setPrice($_price);   
            $_pricetable->save();
        }        
    }
}
