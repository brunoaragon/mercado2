<?php

namespace Rdtech\Masterprice\Model\ResourceModel\Taxrule;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Rdtech\Masterprice\Model\Taxrule', 'Rdtech\Masterprice\Model\ResourceModel\Taxrule');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>