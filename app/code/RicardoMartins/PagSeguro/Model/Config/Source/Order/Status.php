<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Order Statuses source model
 */
namespace RicardoMartins\PagSeguro\Model\Config\Source\Order;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\ObjectManager;

/**
 * Class Status
 * @api
 * @since 100.0.2
 */
class Status implements \Magento\Framework\Option\ArrayInterface
{
    const UNDEFINED_OPTION_LABEL = '-- Please Select --';

    /**
     * @var string[]
     */
    protected $_stateStatuses = [
        \Magento\Sales\Model\Order::STATE_NEW,
        \Magento\Sales\Model\Order::STATE_PROCESSING,
        \Magento\Sales\Model\Order::STATE_COMPLETE,
        \Magento\Sales\Model\Order::STATE_CLOSED,
        \Magento\Sales\Model\Order::STATE_CANCELED,
        \Magento\Sales\Model\Order::STATE_HOLDED,
    ];

    /**
     * @var \Magento\Sales\Model\Order\Config
     */
    protected $_orderConfig;
    

    /**
     * @param \Magento\Sales\Model\Order\Config $orderConfig
     */
    public function __construct(\Magento\Sales\Model\Order\Config $orderConfig, ResourceConnection $resourceConnection)
    {
        $this->_orderConfig = $orderConfig;
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $connection = $this->resourceConnection->getConnection();
        $table = $connection->getTableName('sales_order_status');
        $query = "Select * FROM " . $table;
        $result = $connection->fetchAll($query);

        $options = [['value' => '', 'label' => __('-- Please Select --')]];
        foreach($result as $_status){
            $options[] = ['value' => $_status['status'], 'label' => $_status['label']];
        }
        
        return $options;
    }
}
