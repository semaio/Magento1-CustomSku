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
 * Class Semaio_CustomSku_Block_Adminhtml_Info
 */
class Semaio_CustomSku_Block_Adminhtml_Info extends Mage_Adminhtml_Block_Template
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
