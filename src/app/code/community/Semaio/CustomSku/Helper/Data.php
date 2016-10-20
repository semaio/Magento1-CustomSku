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
 * Class Semaio_CustomSku_Helper_Data
 */
class Semaio_CustomSku_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Retrieve the factory class
     *
     * @return Semaio_CustomSku_Model_Factory
     */
    public function getFactory()
    {
        return Mage::getModel('semaio_customsku/factory');
    }

    /**
     * Retrieve the customer session
     *
     * @return Mage_Customer_Model_Session
     */
    public function getSession()
    {
        return Mage::getSingleton('customer/session');
    }

    /**
     * Retrieve the current customer
     *
     * @return Mage_Customer_Model_Customer
     */
    public function getCustomer()
    {
        return $this->getSession()->getCustomer();
    }

    /**
     * Retrieve the current customer id
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->getCustomer()->getId();
    }

    /**
     * Check if the current customer id matches with the customer id of the model
     *
     * @param  Semaio_CustomSku_Model_CustomSku $model Model
     * @return bool
     */
    public function hasCorrectCustomerId($model)
    {
        if ($model->getData('customer_id') == $this->getCustomerId()) {
            return true;
        }

        return false;
    }
}
