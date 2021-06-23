<?php

namespace Rdtech\Master\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{

    public function isLogged()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');

        return $customerSession->isLoggedIn();
    }

    public function getCustomer()
    {
        if ($this->isLogged()) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $customerSession = $objectManager->create('Magento\Customer\Model\Session');

            return $customerSession->getCustomer();
        } else {
            return false;
        }
    }

    public function getStoreId()
    {
        $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager  = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');

        return $storeManager->getStore()->getStoreId();
    }

    //Price validation and product price update
    public function PriceEnable()
    {
        return boolval($this->scopeConfig->getValue('wsprice/general/enable_price', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }

    public function PriceItem($_product)
    {
        $date = date('Y-m-d');

        $date = strtotime($date);
        $fromDate = strtotime(substr($_product->getSpecialFromDate(),0,10));
        $toDate = strtotime(substr($_product->getSpecialToDate(),0,10));

        if($fromDate){
            if (intval($date) < intval($fromDate)) {
                $_product->setSpecialPrice(null);
            }
        }

        if($toDate){
            if (intval($date) > intval($toDate)) {
                $_product->setSpecialPrice(null);
            }
        }

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $state =  $objectManager->get('Magento\Framework\App\State');
        if ($state->getAreaCode() == "frontend") {
            if ($_product->getProdutoPorPeso()) {
                if ($_product->getSpecialPrice()) {
                    $_product->setSpecialPriceQuilo($_product->getSpecialPrice());
                    $_price = ($_product->getSpecialPrice() / 1000) * $_product->getProdutoPesoUnidade();
                    //$_product->setSpecialPrice(floor($_price * 100) / 100);
                    $_product->setSpecialPrice(($_price * 100) / 100);

                    $_product->setPriceQuilo($_product->getPrice());
                    $_price = ($_product->getPrice() / 1000) * $_product->getProdutoPesoUnidade();
                    //$_product->setPrice(floor($_price * 100) / 100);
                    $_product->setPrice(($_price * 100) / 100);
                } else {
                    $_product->setPriceQuilo($_product->getPrice());
                    $_price = ($_product->getPrice() / 1000) * $_product->getProdutoPesoUnidade();
                    //$_product->setPrice(floor($_price * 100) / 100);
                    $_product->setPrice(($_price * 100) / 100);
                }
            }
        }
    }

    public function PriceCollection($_collect)
    {
        foreach ($_collect as $_item) {
            $this->PriceItem($_item);
        }
    }
}
