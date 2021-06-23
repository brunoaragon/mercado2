<?php
namespace Rdtech\Masterprice\Model\ResourceModel;

class Pricetable extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('pricetable', 'id');
    }
}
?>