<?php

namespace Rdtech\Master\Model;

use \Rdtech\Master\Api\FaixacepInterface;

class Faixacep implements FaixacepInterface
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
    public function getFaixaCep()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->create('\Rdtech\Store\Model\Storemanage')->getCollection();

        $_cep_data = array();

        foreach ($model as $_data) {
            array_push($_cep_data, array('id' => $_data->getId(), 'code' => $_data->getCode(), 'address' => $_data->getAddress(), 'cep_inicio' => $_data->getCepFrom(), 'cep_final' => $_data->getCepTo()));
        }

        return $_cep_data;
    }
}
