<?php

namespace Rdtech\Master\Model;

use \Rdtech\Master\Api\DeliveryorderInterface;

class Deliveryorder implements DeliveryorderInterface
{

    /**
     * @var BestSellersCollectionFactory
     */
    protected $_bestSellersCollectionFactory;
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
    public function insertDelivery()
    {
        $data = json_decode($this->request->getContent());

        $_delivery = $data->delivery;
        $_order_id = $data->order_id;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $_order = $objectManager->create('Magento\Sales\Model\Order')->load($_order_id);

        $_delivery = str_replace("'",'"',$_delivery);

        $_order->setKsDeliveryInfo($_delivery);
        $_order->save();
    }   
}
