<?php

namespace Rdtech\Master\Observer;

use Rdtech\Master\Helper\Data;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ProductItem implements ObserverInterface
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
		$_product = $observer->getEvent()->getProduct();

		$this->helper->PriceItem($_product);		
	}
}
