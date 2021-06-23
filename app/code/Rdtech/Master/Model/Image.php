<?php

namespace Rdtech\Master\Model;

use \Rdtech\Master\Api\ImageInterface;

class Image implements ImageInterface
{
    /**
     * @var \Magento\Customer\Api\Data\AddressInterfaceFactory
     */
    protected $addressFactory;
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;
    /**
     * CustomerAddress constructor.
     * @param \Magento\Customer\Model\AddressFactory $addressFactory
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        \Magento\Customer\Model\AddressFactory $addressFactory,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->addressFactory = $addressFactory;
        $this->request = $request;
    }
    public function insertImage()
    {
        $data = json_decode($this->request->getContent());

        $_sku              = $data->sku;
        $_image             = $data->image;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
        $_product = $productRepository->get($_sku);

        $_product->setExternalImage($_image);
     
        $_product->save();
    }
}
