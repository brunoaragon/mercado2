<?php

namespace Rdtech\Cashback\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\ResourceConnection;

class Data extends AbstractHelper
{
    protected $resourceConnection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
    }

    public function isLogged()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');

        return $customerSession->isLoggedIn();
    }

    public function getCustomer()
    {
        if ($this->isLogged()) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $customerSession = $objectManager->create('Magento\Customer\Model\Session');

            return $customerSession->getCustomer();
        } else {
            return false;
        }
    }

    public function getCashbackCredit()
    {
        if ($this->isLogged()) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $cashback_enable = boolval($objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('cashback/general/enable'));

            if ($cashback_enable) {

                $_cashback_validity = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('cashback/general/validity');

                $connection = $this->resourceConnection->getConnection();

                $query = "
                    SELECT sum(cashback) as cashback 
                    FROM sales_order ord 
                    WHERE ord.created_at BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL " . $_cashback_validity . " day)) AND NOW()
                    AND ord.status = 'complete'
                    AND ord.customer_id = " . $this->getCustomer()->getId() . ";
                    ";
                $result = $connection->fetchAll($query);

                foreach ($result as $_item) {
                    $_cashback = $_item['cashback'];
                }

                $query = "
                    SELECT sum(cashback_used) as cashback_used 
                    FROM sales_order ord 
                    WHERE ord.created_at BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL " . $_cashback_validity . " day)) AND NOW()
                    AND ord.status not in ('pending','aguardando_separacao')
                    AND ord.customer_id = " . $this->getCustomer()->getId() . ";
                    ";
                $result = $connection->fetchAll($query);

                foreach ($result as $_item) {
                    $_cashback_used = $_item['cashback_used'];
                }

                $_cashback_credit = floatval($_cashback - $_cashback_used);

                return $_cashback_credit;
            } else {
                return false;
            }
        }
    }

    public function getCashback()
    {
        if ($this->isLogged()) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $_cashback_validity = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('cashback/general/validity');

            $connection = $this->resourceConnection->getConnection();

            $query = "
                SELECT created_at as date, ADDDATE(created_at, INTERVAL 15 DAY) as validity, cashback, cashback_used, increment_id as id, entity_id 
                FROM sales_order ord 
                WHERE CAST(cashback AS DECIMAL(12,2))  
                AND ord.created_at BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL " . $_cashback_validity . " day)) AND NOW()
                AND ord.customer_id = " . $this->getCustomer()->getId() . "
                ORDER BY increment_id ASC;
                ";
            $result = $connection->fetchAll($query);

            return $result;
        } else {
            return false;
        }
    }
}
