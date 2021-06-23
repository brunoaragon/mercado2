<?php

namespace Rdtech\Master\Model;

use \Rdtech\Master\Api\ProductslideInterface;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory as BestSellersCollectionFactory;

class Productslide implements ProductslideInterface
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
        \Magento\Framework\App\RequestInterface $request,
        BestSellersCollectionFactory $bestSellersCollectionFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    ) {
        $this->addressFactory = $addressFactory;
        $this->request = $request;
        $this->_bestSellersCollectionFactory = $bestSellersCollectionFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
    }
    public function getProducts()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $sliderCollection = $objectManager->create('\Mageplaza\Productslider\Model\Slider')->getCollection();

        $_product_slide = array();

        foreach ($sliderCollection as $_data) {
            $_sliderType = $_data->getProductType();

            $_productsSlider = explode("&", $_data->getProductIds());
            $_categoriesSlider = explode("&", $_data->getCategoriesIds());

            if ($_sliderType == "best-seller") {
                $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
                $storeManager  = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
                $storeID       = $storeManager->getStore()->getStoreId();

                $productIds  = [];
                $bestSellers = $this->_bestSellersCollectionFactory->create()
                    ->setModel('Magento\Catalog\Model\Product')
                    ->addStoreFilter($storeID)
                    ->setPeriod('month');

                foreach ($bestSellers as $product) {
                    $productIds[] = $product->getProductId();
                }

                $_collection = $this->_productCollectionFactory->create()->addIdFilter($productIds);
                $_collection->addMinimalPrice()
                    ->addFinalPrice()
                    ->addTaxPercents()
                    ->addAttributeToSelect('*')
                    ->addStoreFilter($storeID)
                    ->addUrlRewrite()
                    ->setVisibility(4)
                    ->setPageSize(10);

                $_productsSlider = array();

                foreach ($_collection as $_product) {
                    array_push($_productsSlider, $_product->getId());
                }

                $_categoriesSlider = null;
            } else if ($_sliderType == "onsale") {
                $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
                $storeManager  = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
                $storeID       = $storeManager->getStore()->getStoreId();

                $productIds  = [];   

                $now = date('Y-m-d');

                $_collection = $this->_productCollectionFactory->create();
                $_collection->addMinimalPrice()
                    ->addFinalPrice()
                    ->addTaxPercents()
                    ->addAttributeToSelect('name')
                    ->addAttributeToSelect('image')
                    ->addAttributeToSelect('small_image')
                    ->addAttributeToSelect('thumbnail')
                    ->addAttributeToFilter('special_price', ['neq' => ''])
                    ->addAttributeToSelect('special_from_date')
                    ->addAttributeToSelect('special_to_date')
                    ->addAttributeToFilter([
                        [
                            'attribute' => 'special_from_date',
                            'lteq' => date('Y-m-d G:i:s', strtotime($now)),
                            'date' => true,
                        ],
                        [
                            'attribute' => 'special_to_date',
                            'gteq' => date('Y-m-d G:i:s', strtotime($now)),
                            'date' => true,
                        ]
                    ])
                    ->addAttributeToFilter('is_saleable', 1, 'left');

                $_productsSlider = array();

                $_collection->getSelect()->limit(20);
                
                foreach ($_collection as $_product) {
                    array_push($_productsSlider, $_product->getId());
                }

                $_categoriesSlider = null;
            }

            array_push($_product_slide, array('id' => $_data->getSliderId(), 'name' => $_data->getName(), 'type' => $_sliderType, 'products' => $_productsSlider, 'categories' => $_categoriesSlider, 'location' => $_data->getLocation(), 'from_date' => $_data->getFromDate(), 'to_date' => $_data->getToDate(), 'status' => $_data->getStatus()));
        }

        return $_product_slide;
    }
}
