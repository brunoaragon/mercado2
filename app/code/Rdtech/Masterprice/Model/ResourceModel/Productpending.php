<?php
namespace Rdtech\Masterprice\Model\ResourceModel;

class Productpending extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('productpending', 'id');
    }
}
?>