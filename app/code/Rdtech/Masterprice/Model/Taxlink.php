<?php
namespace Rdtech\Masterprice\Model;

class Taxlink extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Rdtech\Masterprice\Model\ResourceModel\Taxlink');
    }
}
?>