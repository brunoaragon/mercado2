<?php

namespace Rdtech\Masterprice\Controller\Adminhtml\Index;

class Productexport extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}