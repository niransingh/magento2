<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Retail\Analytics\Model\Config;

class Server extends \Magento\Framework\App\Config\Value
{
	/**
	 * Save object data.
	 * Validates that the server is set and does not include the protocol.
	 *
	 * @return Nosto_Tagging_Model_Config_Server
	 */
	public function save()
	{
		$server = $this->getValue();		

		return parent::save();
	}
}
