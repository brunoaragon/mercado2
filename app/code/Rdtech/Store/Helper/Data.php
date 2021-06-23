<?php

namespace Rdtech\Store\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\App\Helper\Context;
use \Magento\Framework\App\ResourceConnection;
use \Magento\Framework\App\ObjectManager;

class Data extends AbstractHelper
{
    protected $resourceConnection;
    public function __construct(Context $context, ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
        parent::__construct($context);
    }

    public function getStores($code = null)
    {
        $connection = $this->resourceConnection->getConnection();
        $table = $connection->getTableName('storemanage');

        if($code != null){
            $query = "SELECT * FROM ".$table." WHERE code = '".$code."'";
        } else {
            $query = "SELECT * FROM ".$table;
        }

        $result = $connection->fetchAll($query);
        
        return $result;
    }

    public function getValidateCep($cep_client = null, $store = null)
    {
        $_SESSION['cep_validate'] = false;

        if($cep_client && $store){
            $connection = $this->resourceConnection->getConnection();
            $table = $connection->getTableName('storemanage');
           
            $query = "SELECT * FROM ".$table." WHERE code = '".$store."' AND '".$cep_client."' BETWEEN replace(cep_from,'-','') and replace(cep_to,'-','')";            
            $result = $connection->fetchAll($query);

            $_SESSION['cep_validate'] = true;
            
            return boolval(count($result));
        } else {
            return false;
        }        
    }
}
