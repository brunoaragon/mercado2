<?php

namespace Rdtech\Masterprice\Controller\Adminhtml\Index;

use Mageplaza\BannerSlider\Model\Banner;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Layoutsave extends \Magento\Backend\App\Action
{
    protected $request;
    protected $_moduleFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Mageplaza\BannerSlider\Model\Banner $moduleFactory
    ) {
        $this->_moduleFactory = $moduleFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $_POST['result'];
        $result = json_decode($result);

        $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        foreach ($result as $_item) {
            $item = array_values($_item);
            $_type = $item[0];
            $_id = $item[1];
            $_order = $item[2];

            if ($_type == "banner") {
                $_banner = $_objectManager->get('\Mageplaza\BannerSlider\Model\Slider')->getCollection()
                    ->addFieldToFilter('slider_id', $_id)
                    ->getFirstItem();

                $_banner->setPriority($_order);
                $_banner->save();
            } else if ($_type == "product") {
                $_product = $_objectManager->get('\Mageplaza\Productslider\Model\Slider')->getCollection()
                    ->addFieldToFilter('slider_id', $_id)
                    ->getFirstItem();                

                $_img = $item[3];

                $_product->setTimeCache("$_order");   
                $_product->setTitle("$_img");

                $_product->save();
            }
        }
    }
}
