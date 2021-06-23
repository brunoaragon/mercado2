<?php

namespace Rdtech\Master\Model;

use \Rdtech\Master\Api\TaxaservicoInterface;

class Taxaservico implements TaxaservicoInterface
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
    public function getTaxaServico()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $_taxa = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('mnnmain/mnngeneral/servicetax');
        
        return number_format($_taxa,2);
    }
}
