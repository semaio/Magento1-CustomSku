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
 * Class Semaio_CustomSku_Test_Model_Service_GetCustomSku
 *
 * @group Semaio_CustomSku
 */
class Semaio_CustomSku_Test_Model_Service_GetCustomSku extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var Semaio_CustomSku_Model_Service_GetCustomSkuInterface
     */
    protected $_model;

    /**
     * Set up test class
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_model = Mage::getModel('semaio_customsku/service_getCustomSku');
    }

    /**
     * @test
     * @loadFixture ~Semaio_CustomSku/customer
     * @loadFixture ~Semaio_CustomSku/customsku
     * @doNotIndexAll
     */
    public function execute()
    {
        $customer = Mage::getModel('customer/customer')->load(1);

        $this->assertNull($this->_model->execute('9999', $customer));
        $this->assertEquals('123456', $this->_model->execute('ABC', $customer));
    }
}
