<?php

namespace Rdtech\Mastertheme\Model\ResourceModel\Themecustom;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Rdtech\Mastertheme\Model\Themecustom', 'Rdtech\Mastertheme\Model\ResourceModel\Themecustom');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>