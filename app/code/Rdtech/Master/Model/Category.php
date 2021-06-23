<?php

namespace Rdtech\Master\Model;

use \Rdtech\Master\Api\CategoryInterface;

class Category implements CategoryInterface
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
    public function getCategory()
    {
        $data = json_decode($this->request->getContent());

        $_category_id = $data->id;
        $_nivel = $data->nivel;

        if($_nivel == 1){
            $_nivel = 2;
        } else {
            $_nivel = 3;
        }

        $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();        
        $categoryCollection = $objectManager->get('\Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
        $categories = $categoryCollection->create();
        $categories->addAttributeToSelect('*');

        if($_category_id <= 2){
            $categories->addAttributeToFilter('entity_id', array('gt' => 2));
        } else {
            $categories->addAttributeToFilter('entity_id', $_category_id);
        }

        $categories->addAttributeToFilter('level', $_nivel);
        $categories->addAttributeToFilter('is_active', true);

        $_categories = array();
        $_category_object = array();

        foreach ($categories as $category) {   
            $_category_object = array();    
            $_category_sub = array();     

            array_push($_category_object,$category->getId());
            array_push($_category_object,$category->getName());
            array_push($_category_object,$category->getUrl());

            $subcategories = $category->getChildrenCategories();

            foreach ($subcategories as $subcategory) {  
                $_category_sub = array();     

                array_push($_category_sub,$subcategory->getId());
                array_push($_category_sub,$subcategory->getName());
                array_push($_category_sub,$subcategory->getUrl());

                array_push($_category_object,$_category_sub);
            }

            array_push($_categories,$_category_object);
        }
    
        return $_categories;
    }
}
