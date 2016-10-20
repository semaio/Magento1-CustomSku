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
 * Class Semaio_CustomSku_Model_Resource_CustomSku_Collection
 */
class Semaio_CustomSku_Model_Resource_CustomSku_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Init the model
     */
    protected function _construct()
    {
        $this->_init('semaio_customsku/customSku');
    }

    /**
     * Add customer filter
     *
     * @param  int|Mage_Customer_Model_Customer $customer Customer
     * @return Semaio_CustomSku_Model_Resource_CustomSku_Collection
     */
    public function addCustomerFilter($customer)
    {
        if ($customer instanceof Mage_Customer_Model_Customer) {
            $customer = $customer->getId();
        }

        $this->getSelect()->where('customer_id = ?', $customer);

        return $this;
    }
}
