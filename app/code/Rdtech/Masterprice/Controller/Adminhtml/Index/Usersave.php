<?php

namespace Rdtech\Masterprice\Controller\Adminhtml\Index;

use Rdtech\Masterprice\Model\Usersorder;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Usersave extends \Magento\Backend\App\Action
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

        $users_updated = array();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $collection2 = $objectManager->create('\Rdtech\Masterprice\Model\Usersorder')
                ->getCollection()
                ->getLastItem();

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
                    $collection->setPassword(md5($password));
                }

                $collection->save();

                array_push($users_updated,$collection->getId());
            } else {
                $model->setData(['username' => $username,'password' => md5($password),'is_active' => $status]);
                $model->save();
            }          
        }          

        $collection3 = $objectManager->create('\Rdtech\Masterprice\Model\Usersorder')
            ->getCollection()
            ->addFieldToFilter('id', array('nin' => array($users_updated)))
            ->addFieldToFilter('id', array('lteq' => $collection2->getId()));

        foreach($collection3 as $item3){
            $item3->delete();
        }

        $collection3->save();        
    }
}
