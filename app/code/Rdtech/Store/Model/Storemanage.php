<?php
namespace Rdtech\Store\Model;

class Storemanage extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Rdtech\Store\Model\ResourceModel\Storemanage');
    }
}
?>