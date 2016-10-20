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
 * Class Semaio_CustomSku_Model_Service_GetCustomSku
 */
class Semaio_CustomSku_Model_Service_GetCustomSku
    implements Semaio_CustomSku_Model_Service_GetCustomSkuInterface
{
    /**
     * @var array
     */
    protected static $_cache = array();

    /**
     * @var bool
     */
    protected $_isCacheEnabled = false;

    /**
     * Fetch the custom SKU for the given SKU and customer
     *
     * @param  string                       $sku      SKU
     * @param  Mage_Customer_Model_Customer $customer Customer
     * @return string|null
     */
    public function execute($sku, Mage_Customer_Model_Customer $customer)
    {
        $customerId = $customer->getId();
        $cacheKey = $sku . '_' . $customerId;

        // Load cached data, if applicable
        if ($this->_isCacheEnabled && isset(self::$_cache[$cacheKey])) {
            return self::$_cache[$cacheKey];
        }

        /* @var $collection Semaio_CustomSku_Model_Resource_CustomSku_Collection */
        $collection = Mage::getResourceModel('semaio_customsku/customSku_collection');
        $collection->addCustomerFilter($customerId);
        $collection->addFieldToFilter('sku', $sku);
        $collection->getSelect()->limit(1);

        $model = $collection->getFirstItem();
        if (!$model || !$model->getId()) {
            return null;
        }

        $customSku = $model->getData('custom_sku');
        self::$_cache[$cacheKey] = $customSku;

        return $customSku;
    }

    /**
     * Set the value if caching of the results is enabled
     *
     * @param bool $isCacheEnabled Flag
     */
    public function setIsCacheEnabled($isCacheEnabled)
    {
        $this->_isCacheEnabled = $isCacheEnabled;
    }
}
