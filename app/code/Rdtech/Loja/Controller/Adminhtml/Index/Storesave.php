<?php

namespace Rdtech\Loja\Controller\Adminhtml\Index;

use Rdtech\Loja\Model\Storelocator;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Storesave extends \Magento\Backend\App\Action
{
    protected $request;
    protected $_moduleFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Rdtech\Loja\Model\StorelocatorFactory $moduleFactory
    ) {
        $this->_moduleFactory = $moduleFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $_POST['result'];
        $result = json_decode($result);

        $model = $this->_moduleFactory->create();

        $connection = $model->getResource()->getConnection();
        $tableName = $model->getResource()->getMainTable();
        $connection->truncateTable($tableName);

        foreach ($result as $_item) {
            $variables = array();

            $item = array_values($_item);
            $query = $item[0];

            foreach ($item[1] as $_variable) {
                array_push($variables, $_variable);
            }

            $model->setData(['query' => $query, 'variable' => json_encode($variables)]);
            $model->save();
        }

        
    }
}
