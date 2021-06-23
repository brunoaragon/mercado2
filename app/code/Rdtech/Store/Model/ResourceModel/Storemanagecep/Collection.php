<?php

namespace Rdtech\Store\Model\ResourceModel\Storemanagecep;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Rdtech\Store\Model\Storemanagecep', 'Rdtech\Store\Model\ResourceModel\Storemanagecep');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>