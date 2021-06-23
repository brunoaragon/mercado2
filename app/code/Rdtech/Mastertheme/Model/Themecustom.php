<?php
namespace Rdtech\Mastertheme\Model;

class Themecustom extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Rdtech\Mastertheme\Model\ResourceModel\Themecustom');
    }
}
?>