<?php

namespace Rdtech\Masterprice\Controller\Adminhtml\Index;

use Rdtech\Masterprice\Model\Productpending;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Productexportsend extends \Magento\Backend\App\Action
{
    protected $request;
    protected $_moduleFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Rdtech\Masterprice\Model\ProductpendingFactory $moduleFactory,
        \Magento\Framework\HTTP\Client\Curl $curl
    ) {
        $this->_moduleFactory = $moduleFactory;
        parent::__construct($context);
        $this->curl = $curl;
    }

    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $_product = $objectManager->create('Magento\Catalog\Model\Product')->load($_POST['id']);

        $categoryIds = $_product->getCategoryIds();
        $__categories = "";
        $__i = 1;

        foreach ($categoryIds as $_cat_item) {
            if ($__i < count($categoryIds)) {
                $__categories = $__categories . $_cat_item . ",";
            } else {
                $__categories = $__categories . $_cat_item;
            }

            $__i++;
        }

        $data = array("name" => $_product->getName(), "sku" => $_product->getSku(), "sku_mnn" => $_product->getSku(), "price" => $_product->getPrice(), "shortdescription" => $_product->getShortDescription(), "description" => $_product->getDescription(), "categories" => $__categories, "quantity" => "0", "visibility" => "4", "image" => $_product->getExternalImage(), "produto_por_peso" => $_product->getProdutoPorPeso(), "produto_unidade_medida" => $_product->getProdutoUnidadeMedida(), "produto_peso_unidade" => $_product->getProdutoPesoUnidade());
        $postdata = json_encode($data);

        $url = $_POST['url'] . 'rest/all/V1/mercadonanuvem/product/insert';
        $token = $_POST['token'];

        $authorization = "Authorization: Bearer " . $token;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));

        $result = curl_exec($ch);
        curl_close($ch);

        echo $_POST['store'];
    }
}
