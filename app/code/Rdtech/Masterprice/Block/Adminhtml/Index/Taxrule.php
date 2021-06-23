<?php

namespace Rdtech\Masterprice\Block\Adminhtml\Index;

use \Rdtech\Masterprice\Helper\Data;

class Taxrule extends \Magento\Backend\Block\Widget\Container
{
    public function __construct(\Magento\Backend\Block\Widget\Context $context, array $data = [], Data $helperData)
    {
        parent::__construct($context, $data);
        $this->_helperData = $helperData;
    }

    public function getRules()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->create('\Rdtech\Masterprice\Model\Taxrule');

        return $model;
    }
}
