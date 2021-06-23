<?php

namespace Rdtech\Cashback\Model\Total\Quote;

/**
 * Class Custom
 * @package Meetanshi\HelloWorld\Model\Total\Quote
 */
class Custom extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $_priceCurrency;

    /**
     * Custom constructor.
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(\Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency, \Rdtech\Cashback\Helper\Data $helper)
    {
        $this->_priceCurrency = $priceCurrency;
        $this->helper = $helper;
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this|bool
     */
    public function collect(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');

        if (boolval($customerSession->getCashbackUse())) {
            $_credit = floatval($this->helper->getCashbackCredit());

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $cart = $objectManager->get('\Magento\Checkout\Model\Cart');

            $subTotal = $cart->getQuote()->getSubtotal();

            if ($_credit >= $subTotal) {
                $cashback_total = $subTotal;

                parent::collect($quote, $shippingAssignment, $total);
                $baseDiscount = $cashback_total;
                $discount = $this->_priceCurrency->convert($baseDiscount);
                $total->addTotalAmount('cashback', -$discount);
                $total->addBaseTotalAmount('cashback', -$baseDiscount);
                $total->setBaseGrandTotal($total->getBaseGrandTotal() - $baseDiscount);
                $quote->setCustomDiscount(-$discount);

                $cart->getQuote()->setSubtotal($cashback_total);
                $cart->getQuote()->setGrandTotal($cashback_total);

                return $this;
            } else {
                $cashback_total = $_credit;
            }

            $customerSession->setCashbackCredit($cashback_total);
        } else {
            $cashback_total = 0;
        }

        parent::collect($quote, $shippingAssignment, $total);
        $baseDiscount = $cashback_total;
        $discount = $this->_priceCurrency->convert($baseDiscount);
        $total->addTotalAmount('cashback', -$discount);
        $total->addBaseTotalAmount('cashback', -$baseDiscount);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() - $baseDiscount);
        $quote->setCustomDiscount(-$discount);

        // $quote->collectTotals();

        return $this;
    }
}
