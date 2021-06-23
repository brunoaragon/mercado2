<?php

namespace Rdtech\Store\Model\ResourceModel\Storemanage;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Rdtech\Store\Model\Storemanage', 'Rdtech\Store\Model\ResourceModel\Storemanage');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>