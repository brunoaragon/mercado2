<?php
namespace Rdtech\Mastertheme\Model\ResourceModel;

class Themecustom extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('themecustom', 'id');
    }
}
?>