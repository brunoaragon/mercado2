<?php

namespace Rdtech\Masterprice\Block\Adminhtml\Index;

use \Rdtech\Masterprice\Helper\Data;

class Image extends \Magento\Backend\Block\Widget\Container
{
    public function __construct(\Magento\Backend\Block\Widget\Context $context, array $data = [], Data $helperData)
    {
        parent::__construct($context, $data);
        $this->_helperData = $helperData;
    }

}
