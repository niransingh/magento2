<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Retail\Analytics\Block\Adminhtml\System\Config;

class Button extends \Magento\Config\Block\System\Config\Form\Field
{
	 
	
	/**
	 *  
	 *
	 * @var string
	 */
	protected $_valButtonLabel = 'Validate Server Account';
	
	
	
	/**
	 * Set Validate VAl Button Label
	 *
	 * @param string $valButtonLabel
	 * @return 
	 */
	public function setVatButtonLabel($valButtonLabel)
	{
		$this->_valButtonLabel = $valButtonLabel;
		return $this;
	}
	
	/**
	 * Set template to itself
	 *
	 * @return Retail\Analytics\Block\Adminhtml\System\Config\Button
	 */
	protected function _prepareLayout()
	{
		parent::_prepareLayout();
		if (!$this->getTemplate()) {
			$this->setTemplate('system/config/button.phtml');
		}
		return $this;
	}
	
	/**
	 * Unset some non-related element parameters
	 *
	 * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
	 * @return string
	 */
	public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
	{
		$element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
		return parent::render($element);
	}
	
	/**
	 * Get the button and scripts contents
	 *
	 * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
	 * @return string
	 */
	protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
	{
		$originalData = $element->getOriginalData();
		$buttonLabel = !empty($originalData['button_label']) ? $originalData['button_label'] : $this->_vatButtonLabel;
		$this->addData(
				[
				'button_label' => __($buttonLabel),
				'html_id' => $element->getHtmlId(),
				//'ajax_url' => $this->_urlBuilder->getUrl('customer/system_config_validatevat/validate'),
				]
		);
	
		return $this->_toHtml();
	}
}

