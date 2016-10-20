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
 * Interface Semaio_CustomSku_Model_Service_GetCustomSkuInterface
 */
interface Semaio_CustomSku_Model_Service_GetCustomSkuInterface
{
    /**
     * Fetch the custom SKU for the given SKU and customer
     *
     * @param  string                       $sku      SKU
     * @param  Mage_Customer_Model_Customer $customer Customer
     * @return string|null
     */
    public function execute($sku, Mage_Customer_Model_Customer $customer);

    /**
     * Set the value if caching of the results is enabled
     *
     * @param bool $isCacheEnabled Flag
     */
    public function setIsCacheEnabled($isCacheEnabled);
}
