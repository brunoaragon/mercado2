<?php
namespace Rdtech\Masterprice\Model;

class Pricetablerule extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Rdtech\Masterprice\Model\ResourceModel\Pricetablerule');
    }
}
?>