<?php

namespace Rdtech\Masterprice\Controller\Adminhtml\Index;

use Rdtech\Masterprice\Model\Usersorder;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Userupdate extends \Magento\Backend\App\Action
{
    protected $request;
    protected $_moduleFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Rdtech\Masterprice\Model\UsersorderFactory $moduleFactory
    ) {
        $this->_moduleFactory = $moduleFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $_POST['result'];
        $result = json_decode($result);

        $model = $this->_moduleFactory->create();

        $connection = $model->getResource()->getConnection();
        $tableName = $model->getResource()->getMainTable();
        //$connection->truncateTable($tableName);

        $users_updated = array();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        foreach ($result as $_item) {
            $item = array_values($_item);
            $username = $item[0];
            $password = $item[1];
            $status   = $item[2];  

            $collection = $objectManager->create('\Rdtech\Masterprice\Model\Usersorder')
                ->getCollection()
                ->addFieldToFilter('username',$username)
                ->getFirstItem();

            if($collection->getId() > 0){
                $collection->setIsActive($status);

                if($password != '......'){
                    $collection->setPassword(($password));
                }

                $collection->save();

                array_push($users_updated,$collection->getId());
            }            
        }   

        $collection2 = $objectManager->create('\Rdtech\Masterprice\Model\Usersorder')
            ->getCollection()
            ->addAttributeToFilter('id', array('in' => array($users_updated)));

        foreach($collection2 as $item2){
            $item2->delete();
        }
        $collection2->save();
        
        foreach ($result as $_item) {
            $item = array_values($_item);
            $username = $item[0];
            $password = $item[1];
            $status   = $item[2];  

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $collection = $objectManager->create('\Rdtech\Masterprice\Model\Usersorder')
                ->getCollection()
                ->addFieldToFilter('username',$username);

            if($collection->getId() <= 0){
                $model->setData(['username' => $username,'password' => ($password),'is_active' => $status]);
                $model->save();
            }              
        }   
    }
}
