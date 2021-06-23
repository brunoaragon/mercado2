<?php

namespace Rdtech\Master\Observer;

use Rdtech\Master\Helper\Data;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class OrderNotify implements ObserverInterface
{
	protected $_logger;

	/**
	 * @param \Psr\Log\LoggerInterface $_logger
	 */

	public function __construct(
		\Psr\Log\LoggerInterface $_logger
	) {
		$this->_logger = $_logger;
	}


	public function execute(Observer $observer)
	{
		$_order = $observer->getEvent()->getOrder();

		$_icon = "https://mercadonanuvem.s3-sa-east-1.amazonaws.com/icon.png";
		$_url = "https://fcm.googleapis.com/fcm/send";

		$objectManager =  \Magento\Framework\App\ObjectManager::getInstance();

		$_storeName = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('general/store_information/name');
		$_key = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('mnnmain/mnngeneral/fcmtoken');
		
		$_collectionToken = $objectManager->create('Rdtech\Masterprice\Model\Notification')->getCollection()->load();

		foreach($_collectionToken as $_token){
			$_tokenDevice = trim($_token->getToken());

			$content = [
				'to' => $_tokenDevice,
				'notification' => [
					'title' => $_storeName,
				  	'body' => 'Novo pedido de '.$_order->getCustomerFirstname().' '.$_order->getCustomerLastname().' (R$'.number_format($_order->getGrandTotal(),2,',','.').')',
				  	'icon' => $_icon
				]
			];
			
			$data = json_encode($content);

			$headers = array(
				'Content-Type:application/json',
				'Authorization:key=' . trim($_key)
			);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $_url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			$result = curl_exec($ch);

			if ($result === FALSE) {
				die('Oops! FCM Send Error: ' . curl_error($ch));
			}

			curl_close($ch);
		}
	}
}
