<?php
namespace Rdtech\Master\Model\Total;

class Customfee extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
   /**
     * Collect grand total address amount
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this
     */
    protected $quoteValidator = null; 

    public function __construct(\Magento\Quote\Model\QuoteValidator $quoteValidator)
    {
        $this->quoteValidator = $quoteValidator;
    }
  public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $servicetax = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('mnnmain/mnngeneral/servicetax');

        $exist_amount = 0;
        $customfee = $servicetax;
        $balance = $customfee - $exist_amount;

        $total->setTotalAmount('servicetax', $balance);
        $total->setBaseTotalAmount('servicetax', $balance);

        $total->setServiceTax($balance);
        $total->setBaseServiceTax($balance);

        //$total->setGrandTotal($total->getGrandTotal() + $balance);
        //$total->setBaseGrandTotal($total->getBaseGrandTotal() + $balance);


        return $this;
    } 

    protected function clearValues(Address\Total $total)
    {
        $total->setTotalAmount('subtotal', 0);
        $total->setBaseTotalAmount('subtotal', 0);
        $total->setTotalAmount('tax', 0);
        $total->setBaseTotalAmount('tax', 0);
        $total->setTotalAmount('discount_tax_compensation', 0);
        $total->setBaseTotalAmount('discount_tax_compensation', 0);
        $total->setTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);
    }
    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param Address\Total $total
     * @return array|null
     */
    /**
     * Assign subtotal amount and label to address object
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param Address\Total $total
     * @return array
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $servicetax = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('mnnmain/mnngeneral/servicetax');

        return [
            'code' => 'servicetax',
            'title' => 'Taxa de Serviço',
            'value' => $servicetax
        ];        
    }

    /**
     * Get Subtotal label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Taxa de Serviço');
    }
}