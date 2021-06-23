<?php

namespace Rdtech\Masterprice\Controller\Adminhtml\Index;

use Mageplaza\BannerSlider\Model\Banner;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Layoutheadersave extends \Magento\Backend\App\Action
{
    protected $request;
    protected $_moduleFactory;
    protected $configWriter;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Mageplaza\BannerSlider\Model\Banner $moduleFactory,
        WriterInterface $configWriter
    ) {
        $this->_moduleFactory = $moduleFactory;
        parent::__construct($context);
        $this->configWriter = $configWriter;
    }

    public function execute()
    {
        $result = $_POST['sort'];

        $path = "mnnmain/mnngeneral/sortheader";
        $value = "$result";

        $this->configWriter->save($path, $value, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0);
    }
}
