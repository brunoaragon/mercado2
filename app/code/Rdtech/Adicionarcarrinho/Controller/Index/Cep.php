<?php

namespace Rdtech\Adicionarcarrinho\Controller\Index;

class Cep extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        $_cep = $_POST['codigopostal'];

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $_cepCollection = $objectManager->create('Rdtech\Masterprice\Model\Cep')->getCollection()
            ->addFieldToFilter('cep', trim($_cep))->load()->getFirstItem();

        $return_arr[] = array("logradouro" => $_cepCollection->getLogradouro(),
            "bairro" => $_cepCollection->getBairro(),
            "cidade" => $_cepCollection->getCidade(),
            "uf" => $_cepCollection->getUf());

        echo json_encode($return_arr);
    }
}
