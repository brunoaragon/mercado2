<?php

namespace Rdtech\Master\Observer;

use Rdtech\Master\Helper\Data;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ProductQuoteItem implements ObserverInterface
{
	/** @var Data */
	private $helper;

	public function __construct(
		Data $helper
	) {
		$this->helper = $helper;
	}

	/**
	 * @param Observer $observer
	 */
	public function execute(Observer $observer)
	{
		$item = $observer->getEvent()->getItem();

		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$_product = $objectManager->get('Magento\Catalog\Api\ProductRepositoryInterface')->getById($item->getProductId());

		if ($_product->getProdutoPorPeso()) {
			if ($_product->getSpecialPrice()) {  				
				$_special_price = $_product->getSpecialPrice();

				if(floatval($_product->getPriceQuilo()) <= 0){
					$_special_price = ($_product->getSpecialPrice() / 1000) * $_product->getProdutoPesoUnidade();
					$_special_price = floor($_special_price * 100) / $_product->getProdutoPesoUnidade();
				}

				$item->setCustomPrice($_special_price);
				$item->setOriginalCustomPrice($_special_price);
				$item->getProduct()->setIsSuperMode(true);
            } else {				
				$_price = $_product->getPrice();

				if(floatval($_product->getPriceQuilo()) <= 0){
					$_price = ($_product->getPrice() / 1000) * $_product->getProdutoPesoUnidade();
					$_price = floor($_price * 100) / $_product->getProdutoPesoUnidade();
				}

				$item->setCustomPrice($_price);
				$item->setOriginalCustomPrice($_price);
				$item->getProduct()->setIsSuperMode(true);
            }   			
        }		
	}
}
