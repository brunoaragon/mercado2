<?php

namespace Rdtech\Loja\Model\ResourceModel\Storelocator;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Rdtech\Loja\Model\Storelocator', 'Rdtech\Loja\Model\ResourceModel\Storelocator');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>