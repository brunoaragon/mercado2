<?php

namespace Rdtech\Master\Model;

use \Rdtech\Master\Api\CartitemaddInterface;

class Cartitemadd implements CartitemaddInterface
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
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Quote\Api\CartManagementInterface $quoteManagement,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->productFactory = $productFactory;
        $this->quoteManagement = $quoteManagement;
        $this->quoteRepository = $quoteRepository;
        $this->_customerSession = $customerSession;
        $this->request = $request;
    }


    public function AddQuoteItem()
    {
        $data = json_decode($this->request->getContent());

        $_customer_id = $data->customer_id;
        $_sku = $data->sku;
        $_qty = $data->qty;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
        $productObj = $productRepository->get($_sku);
        $_product_id = $productObj->getId();

        $product = $this->productFactory->create()->load($_product_id);

        $params = array(
            'product' => $_product_id,
            'qty' => $_qty
        );

        $request = new \Magento\Framework\DataObject();
        $request->setData($params);

        $quoteId = $this->quoteManagement->createEmptyCartForCustomer($_customer_id);
        $quote = $this->quoteRepository->get($quoteId);
        $quote->addProduct($product, $request);
        $this->quoteRepository->save($quote);
        $quote->collectTotals();
    }
}
