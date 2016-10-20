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
 * Interface Semaio_CustomSku_Model_Service_CustomSkuInterface
 */
interface Semaio_CustomSku_Model_Service_CheckCustomSkuExistsInterface
{
    /**
     * Checks if the customer already has this custom sku
     *
     * @param  string                       $customSku Custom SKU
     * @param  Mage_Customer_Model_Customer $customer  Customer
     * @return bool
     */
    public function execute($customSku, Mage_Customer_Model_Customer $customer);

    /**
     * Set the model id which should be excluded from the check
     *
     * @param int $excludeId Excluded Model ID
     */
    public function setExcludeId($excludeId);
}
