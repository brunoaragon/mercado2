<?php

namespace Rdtech\Master\Model;

use \Rdtech\Master\Api\DeliveryInterface;

class Delivery implements DeliveryInterface
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
    public function getDeliveryDate()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $servicetax = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('ks_deliverydate/time_slot/ksolves_deliverydate_calendar_timeslot_add_timeslot');

        return $this->unserialize($servicetax);
    }

    /**
     * @param $data
     * @return string
     * @throws \Zend_Serializer_Exception
     */
    public function serialize($data)
    {
        return $this->getSerializeClass()->serialize($data);
    }
    /**
     * @param $string
     * @return mixed
     * @throws \Zend_Serializer_Exception
     */
    public function unserialize($string)
    {
        return $this->getSerializeClass()->unserialize($string);
    }

    /**
     * @return \Zend_Serializer_Adapter_PhpSerialize|mixed
     */
    protected function getSerializeClass()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        return $objectManager->get(\Magento\Framework\Serialize\Serializer\Json::class);
    }
}
