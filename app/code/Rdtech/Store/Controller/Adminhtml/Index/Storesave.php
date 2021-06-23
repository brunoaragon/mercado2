<?php

namespace Rdtech\Store\Controller\Adminhtml\Index;

use Rdtech\Store\Model\Storemanage;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Storesave extends \Magento\Backend\App\Action
{
    protected $request;
    protected $_moduleFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Rdtech\Store\Model\StoremanageFactory $moduleFactory
    ) {
        $this->_moduleFactory = $moduleFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $_POST['result'];
        $result = json_decode($result);

        print_r($result);

        $model = $this->_moduleFactory->create();

        $connection = $model->getResource()->getConnection();
        $tableName = $model->getResource()->getMainTable();
        $connection->truncateTable($tableName);

        foreach ($result as $_item) {
            $item = array_values($_item);
            $store = $item[0];
            $address = $item[1];
            $cep_from = $item[2];
            $cep_to = $item[3];       

            $model->setData(['code' => $store,'address' => $address,'cep_from' => $cep_from,'cep_to' => $cep_to]);
            $model->save();
        }

    }
}
