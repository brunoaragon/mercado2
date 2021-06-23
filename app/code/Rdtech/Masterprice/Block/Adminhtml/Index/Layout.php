<?php

namespace Rdtech\Masterprice\Block\Adminhtml\Index;

use \Rdtech\Masterprice\Helper\Data;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\ObjectManager;

class Layout extends \Magento\Backend\Block\Widget\Container
{
    protected $resourceConnection;

    public function __construct(\Magento\Backend\Block\Widget\Context $context, array $data = [], Data $helperData, ResourceConnection $resourceConnection)
    {
        parent::__construct($context, $data);
        $this->resourceConnection = $resourceConnection;
        $this->_helperData = $helperData;
    }

    public function getSlider()
    {
        $connection = $this->resourceConnection->getConnection();
        $table_banner = $connection->getTableName('mageplaza_bannerslider_slider');
        $table_product = $connection->getTableName('mageplaza_productslider_slider');

        $query = "
        select * from (
            select pro.slider_id as id, 'product' as type, pro.name, pro.status, CAST(pro.time_cache as UNSIGNED) as priority, pro.title as image from $table_product pro where pro.location = 'cms_index_index.content-top'
                union 
            select ban.slider_id as id, 'banner' as type, ban.name, ban.status, CAST(ban.priority as UNSIGNED) as priority, '' as image from $table_banner ban where ban.location = 'cms_index_index.content-top'
        ) x
        order by x.priority        
        ";
        $result = $connection->fetchAll($query);

        return $result;
    }
}
