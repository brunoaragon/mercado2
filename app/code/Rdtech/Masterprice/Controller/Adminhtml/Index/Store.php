<?php

namespace Rdtech\Masterprice\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Store extends \Magento\Backend\App\Action
{
    protected $request;
    protected $_moduleFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $_name   = $_POST['description'];
        $_url    = $_POST['url'];
        $_token  = $_POST['token'];
        $_id     = $_POST['id'];
        $_action = $_POST['action'];

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $_storeRepository = $objectManager->get('Rdtech\Masterprice\Model\Stores')->getCollection()
            ->addFieldToFilter('url',$_url)
            ->addFieldToFilter('token',$_token)
            ->addFieldToFilter('name',$_name)
            ->load();

        if($_action == "1" && count($_storeRepository) > 0){
            $_action = "2";
            $_id = $_storeRepository->getFirstItem()->getId();
        }

        if ($_action == "1") {
            //insert
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $storeRepository = $objectManager->get('Rdtech\Masterprice\Model\Stores');

            $storeRepository->setName($_name);
            $storeRepository->setUrl($_url);
            $storeRepository->setToken($_token);
            $storeRepository->save();
        } else if ($_action == "2") {
            //update            
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $storeRepository = $objectManager->get('Rdtech\Masterprice\Model\Stores')->load($_id);

            $storeRepository->setName($_name);
            $storeRepository->setUrl($_url);
            $storeRepository->setToken($_token);
            $storeRepository->save();
        } else if ($_action == "3") {
            //delete
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $storeRepository = $objectManager->get('Rdtech\Masterprice\Model\Stores')->load($_id);

            $storeRepository->delete();
        }
    }
}
