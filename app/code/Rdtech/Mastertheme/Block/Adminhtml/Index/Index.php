<?php

namespace Rdtech\Mastertheme\Block\Adminhtml\Index;

use \Rdtech\Mastertheme\Helper\Data;

class Index extends \Magento\Backend\Block\Widget\Container
{
    public function __construct(\Magento\Backend\Block\Widget\Context $context, array $data = [], Data $helperData)
    {
        parent::__construct($context, $data);
        $this->_helperData = $helperData;
    }

    public function getTheme($attr)
    {
        return $this->_helperData->getTheme($attr);
    }
}
