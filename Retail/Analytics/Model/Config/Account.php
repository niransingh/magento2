<?php

/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Retail\Analytics\Model\Config;

class Account extends \Magento\Framework\App\Config\Value
{
    /**
     * Save object data.
     * Validates that the account is set.
     *
     * @return Nosto_Tagging_Model_Config_Account
     */
    public function save()
    {
        $account = $this->getValue();
       

        return parent::save();
    }
}
