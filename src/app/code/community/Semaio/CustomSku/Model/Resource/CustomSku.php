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
 * Class Semaio_CustomSku_Model_Resource_CustomSku
 */
class Semaio_CustomSku_Model_Resource_CustomSku
    extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Init the main table and primary key field
     */
    protected function _construct()
    {
        $this->_init('semaio_customsku/customsku', 'id');
    }
}
