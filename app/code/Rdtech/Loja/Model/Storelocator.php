<?php
namespace Rdtech\Loja\Model;

class Storelocator extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Rdtech\Loja\Model\ResourceModel\Storelocator');
    }
}
?>