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
 * Class Semaio_CustomSku_Test_Helper_Data
 *
 * @group Semaio_CustomSku
 */
class Semaio_CustomSku_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * @var Semaio_CustomSku_Helper_Data
     */
    protected $_helper;

    /**
     * Set up test class
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_helper = Mage::helper('semaio_customsku');
    }

    /**
     * @test
     */
    public function getFactory()
    {
        $this->assertInstanceOf('Semaio_CustomSku_Model_Factory', $this->_helper->getFactory());
    }

    /**
     * @test
     */
    public function getSession()
    {
        $this->assertInstanceOf('Mage_Customer_Model_Session', $this->_helper->getSession());
    }

    /**
     * @test
     */
    public function getCustomer()
    {
        $this->assertInstanceOf('Mage_Customer_Model_Customer', $this->_helper->getCustomer());
    }

    /**
     * @test
     * @singleton customer/session
     * @loadFixture ~Semaio_CustomSku/customer
     * @doNotIndexAll
     */
    public function getCustomerId()
    {
        $this->setCurrentStore(Mage_Core_Model_Store::DEFAULT_CODE);
        $customer = Mage::getModel('customer/customer')->load(1);

        $customerSessionMock = $this->getModelMock('customer/session', array('getCustomer'));
        $customerSessionMock->expects($this->any())
            ->method('getCustomer')
            ->will($this->returnValue($customer));
        $customerSessionMock->setId(1);
        $this->replaceByMock('singleton', 'customer/session', $customerSessionMock);

        $this->assertEquals(1, $this->_helper->getCustomerId());
    }

    /**
     * @test
     * @singleton customer/session
     * @loadFixture ~Semaio_CustomSku/customer
     * @doNotIndexAll
     */
    public function hasCorrectCustomerId()
    {
        $this->setCurrentStore(Mage_Core_Model_Store::DEFAULT_CODE);
        $customer = Mage::getModel('customer/customer')->load(1);

        $customerSessionMock = $this->getModelMock('customer/session', array('getCustomer'));
        $customerSessionMock->expects($this->any())
            ->method('getCustomer')
            ->will($this->returnValue($customer));
        $customerSessionMock->setId(1);
        $this->replaceByMock('singleton', 'customer/session', $customerSessionMock);

        $model = new Varien_Object();

        $model->setData('customer_id', 2);
        $this->assertFalse($this->_helper->hasCorrectCustomerId($model));

        $model->setData('customer_id', 1);
        $this->assertTrue($this->_helper->hasCorrectCustomerId($model));
    }
}
