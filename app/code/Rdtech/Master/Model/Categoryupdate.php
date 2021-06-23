<?php

namespace Rdtech\Master\Model;

use \Rdtech\Master\Api\CategoryupdateInterface;

class Categoryupdate implements CategoryupdateInterface
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
    public function updateCategory()
    {
        $data = json_decode($this->request->getContent());

        $_id = $data->id;
        $_name = $data->name;
        $_parent = $data->parent;

        if(intval($_id) > 2){
            $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();

            $parentCategory = $_objectManager->create('Magento\Catalog\Model\Category')->load($_parent);
            $category = $_objectManager->create('Magento\Catalog\Model\Category');
            
            $cate = $category->getCollection()
                ->addAttributeToFilter('entity_id',$_id)
                ->getFirstItem();

            if($cate->getId() == NULL) {
                $category->setPath($parentCategory->getPath())
                    ->setParentId($_parent)
                    ->setName($_name)
                    ->setIsActive(true);
                $category->save();
                return $category->getId();
            } else {
                $category = $_objectManager->get('\Magento\Catalog\Model\Category')->load($cate->getId());

                $category->setName($_name);
                $category->save();
            }
        }
    }
}
