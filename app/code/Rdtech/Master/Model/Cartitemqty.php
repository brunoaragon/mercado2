<?php

namespace Rdtech\Master\Model;

use \Rdtech\Master\Api\CartitemqtyInterface;

class Cartitemqty implements CartitemqtyInterface
{

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
    public function setQuoteQty()
    {
        $post = $this->request->getContent();

        $data = str_replace('"[', '[', $post);
        $data = str_replace(']"', ']', $data);
        $data = str_replace('\n', '', $data);
        $data = trim($data);

        $data = json_decode($data);

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        
        for ($i = 0; $i < sizeof($data); $i++) {
            $_quote = $data[$i]->quote_id;
            $_sku = $data[$i]->sku;
            $_qty = $data[$i]->qty;
            
            $quoteFactory = $objectManager->create('\Magento\Quote\Model\QuoteFactory');
            $_quote = $quoteFactory->create()->load($_quote);

            $allItems = $_quote->getAllVisibleItems();
            foreach ($allItems as $item) {
                if ($item->getSku() == $_sku) {
                    $item->setQty($_qty);
                    $item->calcRowTotal();
                    $item->save();
                }
            }
        }     
    }
}
