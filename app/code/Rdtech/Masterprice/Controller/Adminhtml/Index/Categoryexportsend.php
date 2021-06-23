<?php

namespace Rdtech\Masterprice\Controller\Adminhtml\Index;

use Rdtech\Masterprice\Model\Productpending;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Categoryexportsend extends \Magento\Backend\App\Action
{
    protected $request;
    protected $_moduleFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Rdtech\Masterprice\Model\ProductpendingFactory $moduleFactory,
        \Magento\Framework\HTTP\Client\Curl $curl
    ) {
        $this->_moduleFactory = $moduleFactory;
        parent::__construct($context);
        $this->curl = $curl;
    }

    public function execute()
    {
        $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $_category = $_objectManager->get('\Magento\Catalog\Model\Category')->load($_POST['id']);

        $data = array("id" => $_category->getId(), "parent" => $_category->getParentId(), "name" => $_category->getName());
        $postdata = json_encode($data);
    
        $url = $_POST['url'].'rest/all/V1/mercadonanuvem/category/update';
        $token = $_POST['token'];
        
        $authorization = "Authorization: Bearer ".$token;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));

        $result = curl_exec($ch);
        curl_close($ch);

        echo $_POST['store'];     
    }
}
