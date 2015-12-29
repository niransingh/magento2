<?php

namespace Retail\Analytics\Helper;


class Session extends \Magento\Framework\App\Helper\AbstractHelper
{
	
	
	public function isLoggedIn()
	{		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$customerSession = $objectManager->create('Magento\Customer\Model\Session');
		return $customerSession->isLoggedIn();
	}
	
	public function getCustomer()
	{	
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$customerSession = $objectManager->create('Magento\Customer\Model\Session');
		return $customerSession->getCustomer();	
	} 
	
	public function getCustomerSession()
	{
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$customerSession = $objectManager->create('Magento\Customer\Model\Session');
		return $customerSession;
	}
	 
	public function getCheckoutSession()
	{
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$checkoutSession = $objectManager->create('Magento\Checkout\Model\Session');
		return $checkoutSession;
	}
}