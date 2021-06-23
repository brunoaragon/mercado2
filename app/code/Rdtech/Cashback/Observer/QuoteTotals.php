<?php

namespace Rdtech\Cashback\Observer;

use Rdtech\Cashback\Helper\Data;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class QuoteTotals implements ObserverInterface
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
		/*
        $item = $observer->getEvent()->getItem();
        $quote = $item->getQuote(); 
        
        $quote->collectTotals();
		*/

		$quote = $observer->getEvent()->getQuote();

		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$customerSession = $objectManager->create('Magento\Customer\Model\Session');

		if ($customerSession->getCashbackUse()) {
			$quote->collectTotals();
		}
	}
}
