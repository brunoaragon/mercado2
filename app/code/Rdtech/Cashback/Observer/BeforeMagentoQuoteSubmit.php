<?php

namespace Rdtech\Cashback\Observer;

use Magento\Checkout\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class BeforeMagentoQuoteSubmit
 */
class BeforeMagentoQuoteSubmit implements ObserverInterface
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @param Session $checkoutSession
     *
     * @codeCoverageIgnore
     */
    public function __construct(
        Session $checkoutSession
    ) {
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $_order = $observer->getEvent()->getOrder();
        $_quote_total = $_order->getGrandTotal();

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cashback_enable = boolval($objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('cashback/general/enable'));
        $cashback_percentage = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('cashback/general/percentage');
        $cashback_min_value = floatval($objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('cashback/general/min_value'));
        $cashback_max_value = floatval($objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('cashback/general/max_value'));

        if ($cashback_enable) {
            if (floatval($_quote_total) > floatval($cashback_min_value)) {
                $customerSession = $objectManager->create('Magento\Customer\Model\Session');

                if ((floatval($_quote_total) <= $cashback_max_value) || ($cashback_max_value == 0)) {
                    $_value = $_quote_total;
                } else {
                    $_value = $cashback_max_value;
                }

                $_cashback = ($cashback_percentage / 100) * $_value;

                $_order->setData('cashback', $_cashback);
                $_order->setData('cashback_used', $customerSession->getCashbackCredit());

                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $customerSession = $objectManager->create('Magento\Customer\Model\Session');
                
                $customerSession->setCashbackUse(false);
                $customerSession->setCashbackCredit(false);
            }
        }
    }
}
