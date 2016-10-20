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
 * Class Semaio_CustomSku_Test_Model_Observer
 *
 * @group Semaio_CustomSku
 */
class Semaio_CustomSku_Test_Model_Observer extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var Semaio_CustomSku_Model_Observer
     */
    protected $_model;

    /**
     * Set up test class
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_model = Mage::getModel('semaio_customsku/observer');
    }

    /**
     * @test
     * @loadFixture ~Semaio_CustomSku/customer
     * @loadFixture ~Semaio_CustomSku/customsku
     * @doNotIndexAll
     */
    public function setCustomSkuOnQuoteItem()
    {
        $product = new Varien_Object();
        $product->setData('sku', 'ABC');

        $customer = Mage::getModel('customer/customer')->load(1);
        $quote = new Varien_Object();
        $quote->setData('customer', $customer);

        $quoteItem = new Varien_Object();
        $quoteItem->setData('quote', $quote);


        $event = new Varien_Event();
        $event->setData('product', $product);
        $event->setData('quote_item', $quoteItem);

        $observer = new Varien_Event_Observer();
        $observer->setEvent($event);


        $this->_model->setCustomSkuOnQuoteItem($observer);

        $this->assertEquals('123456', $observer->getEvent()->getQuoteItem()->getData('custom_sku'));
    }
}
