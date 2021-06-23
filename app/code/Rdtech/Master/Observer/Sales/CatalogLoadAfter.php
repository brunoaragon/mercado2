<?php
namespace Rdtech\Master\Observer\Sales;

use Magento\Framework\Event\ObserverInterface;

class CatalogLoadAfter implements ObserverInterface
{

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getOrder();
        $extensionAttributes = $product->getExtensionAttributes();    

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');

        $extensionAttributes->setStockQtd('999');
        $product->setExtensionAttributes($extensionAttributes);
    }    
}
