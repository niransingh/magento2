<?php
namespace Retail\Analytics\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	
	/**
	 * Path to cached image width .
	 */
	const XML_PATH_IMAGE_WIDTH = 'retail_analytics/settings/imagewidth';
	
	/**
	 * Path to cached image height .
	 */
	const XML_PATH_IMAGE_HEIGHT = 'retail_analytics/settings/imageheight';
	
	/**
	 * Path to get client specific resource directory .
	 */
	const XML_PATH_RESOURCEDIR = 'retail_analytics/settings/resourcedir';	
	
	/**
	 * Path to store config raa service server address.
	 */
	const XML_PATH_SERVER = 'retail_analytics/settings/server';
	
	/**
	 * Path to store config raa service account name.
	 */
	const XML_PATH_ACCOUNT = 'retail_analytics/settings/account';
	

	/**
	 * Path to store config raa module enabled state.
	 */
	const XML_PATH_ENABLED = 'retail_analytics/settings/enabled';
	
	public function getEnabled()
	{
		return $this->scopeConfig->getValue(
				self::XML_PATH_ENABLED,\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
	}
	
	public function getServer()
	{
		return $this->scopeConfig->getValue(
				self::XML_PATH_SERVER,\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
	}
	
	public function getAccount()
	{
		return $this->scopeConfig->getValue(
				self::XML_PATH_ACCOUNT,\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
	}
	
	public function getResourcedir()
	{
		return $this->scopeConfig->getValue(
				self::XML_PATH_RESOURCEDIR,\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
	}
	
	public function getImageWidth()
	{
		return $this->scopeConfig->getValue(
				self::XML_PATH_IMAGE_WIDTH,\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
	}
	
	public function getImageHeight()
	{
		return $this->scopeConfig->getValue(
				self::XML_PATH_IMAGE_HEIGHT,\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
	}
}