<?php

namespace Rdtech\Master\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;

class ProductPlugin
{
    protected $productExtensionFactory;
    protected $productFactory;

    public function __construct(
        \Magento\Catalog\Api\Data\ProductExtensionFactory $productExtensionFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory
    ) {
        $this->productFactory = $productFactory;
        $this->productExtensionFactory = $productExtensionFactory;
    }

    public function afterGet(
        \Magento\Catalog\Api\ProductRepositoryInterface $subject,
        \Magento\Catalog\Api\Data\ProductInterface $entity
    ) {
        /** @var ProductInterface $product */
        $product = $entity;
        // Fetch the raw product model (I have not found a better way), and set the data onto our attribute.
        //$productModel = $this->productFactory->create()->load($product->getId());
        $extensionAttributes = $product->getExtensionAttributes();
        /** get current extension attributes from product **/

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $_product = $objectManager->create('Magento\Catalog\Model\Product')->load($entity->getId());
        
        $StockState = $objectManager->get('\Magento\CatalogInventory\Api\StockStateInterface');
        $stockQty = $StockState->getStockQty($_product->getId(), $_product->getStore()->getWebsiteId());

        $extensionAttributes->setStockQtd($stockQty);
        $product->setExtensionAttributes($extensionAttributes);       

        return $product;

    }

    public function afterGetList(
        \Magento\Catalog\Api\ProductRepositoryInterface $subject,
        \Magento\Catalog\Api\Data\ProductSearchResultsInterface $searchCriteria
    ): \Magento\Catalog\Api\Data\ProductSearchResultsInterface {
        $products = [];

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        foreach ($searchCriteria->getItems() as $entity) {
            /** @var ProductInterface $product */

            $extensionAttributes = $entity->getExtensionAttributes();
            
            $product = $objectManager->create('Magento\Catalog\Model\Product')->load($entity->getId());
            
            $StockState = $objectManager->get('\Magento\CatalogInventory\Api\StockStateInterface');
            $stockQty = $StockState->getStockQty($product->getId(), $product->getStore()->getWebsiteId());

            $extensionAttributes->setStockQtd($stockQty);
            $entity->setExtensionAttributes($extensionAttributes);

            $products[] = $entity;
        }

        $searchCriteria->setItems($products);

        return $searchCriteria;
    }
}
