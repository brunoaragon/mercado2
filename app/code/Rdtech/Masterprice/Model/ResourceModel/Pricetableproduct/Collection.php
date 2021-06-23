<?php

namespace Rdtech\Masterprice\Model\ResourceModel\Pricetableproduct;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Rdtech\Masterprice\Model\Pricetableproduct', 'Rdtech\Masterprice\Model\ResourceModel\Pricetableproduct');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>