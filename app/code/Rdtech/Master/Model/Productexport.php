<?php

namespace Rdtech\Master\Model;

use \Rdtech\Master\Api\ProductexportInterface;

class Productexport implements ProductexportInterface
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
        $_produto_por_peso       = $data->produto_por_peso;
        $_produto_unidade_medida = $data->produto_unidade_medida;
        $_produto_peso_unidade   = $data->produto_peso_unidade;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $categories_id = null;
        if($_categories){       
            $categories_list = explode(',',$_categories);
            $categories_id = array();
           
            foreach($categories_list as $category){
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
                'max_sale_qty' => 9999, 
                'is_in_stock' => 1, 
                'qty' => $_quantity
                )
            );

        $_product->save();
    }
}
