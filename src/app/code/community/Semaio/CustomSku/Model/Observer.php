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
 * Class Semaio_CustomSku_Model_Observer
 */
class Semaio_CustomSku_Model_Observer
{
    /**
     * Set the custom sku on the quote item
     * Event: <sales_quote_item_set_product>
     *
     * @param Varien_Event_Observer $observer Observer
     */
    public function setCustomSkuOnQuoteItem(Varien_Event_Observer $observer)
    {
        /* @var Mage_Sales_Model_Quote_Item $quoteItem */
        $quoteItem = $observer->getEvent()->getQuoteItem();
        /* @var $product Mage_Catalog_Model_Product */
        $product = $observer->getEvent()->getProduct();

        $service = $this->getFactory()->getServiceGetCustomSku();

        // Fetch custom sku for customer and add to quote item
        $customSku = $service->execute($product->getSku(), $quoteItem->getQuote()->getCustomer());
        if (null !== $customSku) {
            $quoteItem->setData('custom_sku', $customSku);
        }
    }

    /**
     * Adminhtml block html before
     *
     * @param Varien_Event_Observer $observer Observer
     */
    public function adminhtmlBlockHtmlBefore(Varien_Event_Observer $observer)
    {
//        $block = $observer->getEvent()->getBlock();

//        $block = $observer->getBlock();
//        if ($block instanceof Mage_Adminhtml_Block_Cms_Block_Edit) {
//            switch ($block->getType()) {
//                case 'adminhtml/sales_order_create_form_account': // Specify which form to add custom field to.
//                    $form = $block->getForm();
//                    $fieldset = $form->getElement('main'); // Fieldset name may vary.
//                    $fieldset->addField('reference', 'text', array(
//                            'name' => 'reference',
//                            'label' => Mage::helper('cms')->__('Reference'),
//                            'title' => Mage::helper('cms')->__('Reference')
//                        )
//                    );
//                    break;
//            }
//        }
    }

    /**
     * Retrieve the factory class
     *
     * @return Semaio_CustomSku_Model_Factory
     */
    public function getFactory()
    {
        return Mage::getModel('semaio_customsku/factory');
    }
}
