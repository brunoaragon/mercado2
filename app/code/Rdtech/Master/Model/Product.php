<?php

namespace Rdtech\Master\Model;

use \Rdtech\Master\Api\ProductInterface;

class Product implements ProductInterface
{
    protected $notifierPool;
    /**
     * @var \Magento\Customer\Api\Data\AddressInterfaceFactory
     */
    protected $addressFactory;
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    protected $date;
    /**
     * CustomerAddress constructor.
     * @param \Magento\Customer\Model\AddressFactory $addressFactory
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        \Magento\Customer\Model\AddressFactory $addressFactory,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\Notification\NotifierInterface $notifierPool
    ) {
        $this->addressFactory = $addressFactory;
        $this->request = $request;
        $this->notifierPool = $notifierPool;
        $this->date = $date;
    }
    public function insertProduct()
    {
        $data = json_decode($this->request->getContent());

        $_name              = $data->name;
        $_sku               = $data->sku;
        $_price             = $data->price;
        $_description       = $data->description;
        $_shortdescription  = $data->shortdescription;
        $_categories        = $data->categories;
        $_quantity          = $data->quantity;
        $_visibility        = $data->visibility;
        $_image             = $data->image;
        $_sku_mnn           = $data->sku_mnn;
        $_produto_por_peso       = $data->produto_por_peso;
        $_produto_unidade_medida = $data->produto_unidade_medida;
        $_produto_peso_unidade   = $data->produto_peso_unidade;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $product = $objectManager->get('Magento\Catalog\Model\Product');

        $collection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');
        $_collection = $collection->addAttributeToSelect('*')->addAttributeToFilter('sku_mnn', $_sku_mnn);        

        if($product->getIdBySku($_sku) || count($_collection) > 0) {    
            if( count($_collection) > 0) {                   
                $_productCollection = $_collection->getFirstItem();
            } else {
                $productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');
                $_productCollection = $productCollection->addAttributeToFilter('sku', $_sku)->getFirstItem();
            }

            $currentTime = $this->date->gmtDate();

            $categories_id = null;
            if ($_categories) {
                $categories_list = explode(',', $_categories);
                $categories_id = array();

                foreach ($categories_list as $category) {
                    array_push($categories_id, $category);
                }
            }

            if(!$_productCollection->getSkuProprio()){
                $_productCollection->setSku($_sku);
            }

            $_productCollection->setName($_name);            
            $_productCollection->setShortDescription($_shortdescription);
            $_productCollection->setDescription($_description);
            $_productCollection->setExternalImage($_image);
            $_productCollection->setProdutoPorPeso($_produto_por_peso);
            $_productCollection->setProdutoUnidadeMedida($_produto_unidade_medida);
            $_productCollection->setProdutoPesoUnidade($_produto_peso_unidade);
            $_productCollection->setCategoryIds($categories_id);
            $_productCollection->setUpdatedAt($currentTime);
            $_productCollection->save();
        } else {
            $categories_id = null;
            if ($_categories) {
                $categories_list = explode(',', $_categories);
                $categories_id = array();

                foreach ($categories_list as $category) {
                    array_push($categories_id, $category);
                }
            }

            $_product = $objectManager->create('Magento\Catalog\Model\Product');
            $_product->setName($_name);
            $_product->setTypeId('simple');
            $_product->setAttributeSetId(4);
            $_product->setSku($_sku);
            $_product->setStatus(2);
            $_product->setShortDescription($_shortdescription);
            $_product->setDescription($_description);
            $_product->setExternalImage($_image);
            $_product->setProdutoPorPeso($_produto_por_peso);
            $_product->setProdutoUnidadeMedida($_produto_unidade_medida);
            $_product->setProdutoPesoUnidade($_produto_peso_unidade);
            $_product->setWebsiteIds(array(1));
            $_product->setVisibility($_visibility);
            $_product->setPrice($_price);
            $_product->setCategoryIds($categories_id);
            $_product->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'min_sale_qty' => 1,
                'max_sale_qty' => 99999,
                'is_in_stock' => 1,
                'qty' => $_quantity
            ));

            $_product->save();

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $__product = $objectManager->get('Magento\Catalog\Model\Product')->loadByAttribute('sku', $_sku);

            $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');

            $NotificationUrl = $storeManager->getStore()->getBaseUrl() . 'admin/catalog/product/edit/id/' . $__product->getId();

            $this->notifierPool->addNotice(
                "O produto '" . $_name . "' já está disponível. (ID: " . $__product->getId() . ")",
                'Verifique as informações do produto e habilite caso esteja disponível em sua loja.',
                $NotificationUrl
            );            
        }       
    }
}
