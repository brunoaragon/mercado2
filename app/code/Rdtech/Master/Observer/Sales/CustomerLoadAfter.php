<?php
namespace Rdtech\Master\Observer\Sales;

use Magento\Framework\Event\ObserverInterface;

class CustomerLoadAfter implements ObserverInterface
{

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getOrder();
        $extensionAttributes = $order->getExtensionAttributes();

        if ($extensionAttributes === null) {
            $extensionAttributes = $this->getOrderExtensionDependency();
        }

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
        $store_url = $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);        

        $store_telefone = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('bizkicksettings/footer_contant/phone');

        $extensionAttributes->setStoreUrl($store_url);        
        $order->setExtensionAttributes($extensionAttributes);

        $extensionAttributes->setStoreTelefone($store_telefone);
        $order->setExtensionAttributes($extensionAttributes);
    }

    private function getOrderExtensionDependency()
    {
        $orderExtension = \Magento\Framework\App\ObjectManager::getInstance()->get(
            '\Magento\Sales\Api\Data\OrderExtension'
        );

        return $orderExtension;
    }
}
