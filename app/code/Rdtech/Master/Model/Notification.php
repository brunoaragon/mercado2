<?php

namespace Rdtech\Master\Model;

use \Rdtech\Master\Api\NotificationInterface;

class Notification implements NotificationInterface
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
    public function updateNotification()
    {
        $data = json_decode($this->request->getContent());        
        $_token = $data->token;   
        $_customer_id = $data->customer_id;      

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $_collection = $objectManager->create('Rdtech\Masterprice\Model\Notification')->getCollection()
            ->addFieldToFilter('token', trim($_token))->load();

        if(count($_collection) < 1){
            $_product = $objectManager->create('Rdtech\Masterprice\Model\Notification');
            $_product->setToken($_token);
            $_product->setCustomerId($_customer_id);
        
            $_product->save();
        }
        
    }
}
