<?php
/**
 * This file is part of the Semaio_CustomSku module.
 *
 * See LICENSE.md bundled with this module for license details.
 *
 * @category  Semaio
 * @package   Semaio_CustomSku
 * @author    semaio GmbH <hello@semaio.com>
 * @copyright 2016 semaio GmbH (http://www.semaio.com)
 */

/**
 * Class Semaio_CustomSku_Block_Info
 *
 * @method Mage_Sales_Model_Quote_Item|Mage_Sales_Model_Order_Item getItem()
 */
class Semaio_CustomSku_Block_Info extends Mage_Core_Block_Template
{
    /**
     * Retrieve the custom sku
     *
     * @return string
     */
    public function getCustomSku()
    {
        if ($this->getParentBlock() && $this->getParentBlock()->getItem()) {
            return $this->getParentBlock()->getItem()->getData('custom_sku');
        }

        return null;
    }
}
