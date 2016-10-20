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
 * Class Semaio_CustomSku_Model_Factory
 */
class Semaio_CustomSku_Model_Factory
{
    /**
     * Retrieve the service
     *
     * @return Semaio_CustomSku_Model_Service_GetCustomSkuInterface
     */
    public function getServiceGetCustomSku()
    {
        /* @var $service Semaio_CustomSku_Model_Service_GetCustomSkuInterface */
        $service = Mage::getModel('semaio_customsku/service_getCustomSku');
        $service->setIsCacheEnabled(true);

        return $service;
    }

    /**
     * Retrieve the service
     *
     * @return Semaio_CustomSku_Model_Service_CheckCustomSkuExistsInterface
     */
    public function getServiceCheckCustomSkuExits()
    {
        /** @var $service Semaio_CustomSku_Model_Service_CheckCustomSkuExistsInterface */
        $service = Mage::getModel('semaio_customsku/service_checkCustomSkuExists');

        return $service;
    }
}
