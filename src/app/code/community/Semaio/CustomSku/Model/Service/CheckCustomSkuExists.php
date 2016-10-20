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
 * Class Semaio_CustomSku_Model_Service_Sku
 */
class Semaio_CustomSku_Model_Service_CheckCustomSkuExists
    implements Semaio_CustomSku_Model_Service_CheckCustomSkuExistsInterface
{
    /**
     * @var null|int
     */
    protected $_excludeId = null;

    /**
     * Checks if the customer already has this custom sku
     *
     * @param  string                       $customSku Custom SKU
     * @param  Mage_Customer_Model_Customer $customer  Customer
     * @return bool
     */
    public function execute($customSku, Mage_Customer_Model_Customer $customer)
    {
        /* @var $collection Semaio_CustomSku_Model_Resource_CustomSku_Collection */
        $collection = Mage::getResourceModel('semaio_customsku/customSku_collection');
        $collection->addCustomerFilter($customer);
        $collection->addFieldToFilter('custom_sku', $customSku);

        // Exclude the given model id
        if (null !== $this->_excludeId) {
            $collection->addFieldToFilter('id', array('neq' => $this->_excludeId));
        }

        // Check if there is a result
        if ($collection->count()) {
            return true;
        }

        return false;
    }

    /**
     * Set the model id which should be excluded from the check
     *
     * @param int $excludeId Excluded Model ID
     */
    public function setExcludeId($excludeId)
    {
        $this->_excludeId = $excludeId;
    }
}
