<?php

namespace Rdtech\Loja\Block\Adminhtml\Index;

class Index extends \Magento\Backend\Block\Widget\Container
{
    public function __construct(\Magento\Backend\Block\Widget\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    public function getStores()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->create('\Rdtech\Loja\Model\Storelocator');

        return $model;
    }
}
