<?php
namespace Rdtech\Store\Model\ResourceModel;

class Storemanagecep extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('storemanagecep', 'id');
    }
}
?>