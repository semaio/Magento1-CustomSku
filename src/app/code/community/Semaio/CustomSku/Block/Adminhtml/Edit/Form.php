<?php
/**
 * This file is part of the Semaio_CustomSku module.
 *
 * See LICENSE.md bundled with this module for license details.
 *
 * @category  Semaio
 * @package   Semaio_CustomSku
 * @author    Nicolas Graeter <info@graeter-it.de>
 * @copyright 2016 semaio GmbH (http://www.semaio.com)
 */

/**
 * Class Semaio_CustomSku_Block_Adminhtml_Edit_Form
 */
class Semaio_CustomSku_Block_Adminhtml_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare the custom sku form
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getData('action'),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $customer = Mage::registry('current_customer');
        $customSku = Mage::registry('current_customsku');

        if ($customSku->getId()) {
            $form->addField('id', 'hidden', array(
                'name' => 'id',
            ));
            $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $customSku->getSku());
        } else {
            $product = Mage::getModel('catalog/product');
            $customSku->setData('customer_id', $customer->getId());
        }

        $form->addField('customer_id', 'hidden', array('name' => 'customer_id'));
        $form->setValues($customSku->getData());

        $fieldset = $form->addFieldset('customsku', array(
            'legend' => Mage::helper('semaio_customsku')->__('Custom SKU')
        ));

        $fieldset->addField('customer', 'label', array(
            'label' => Mage::helper('semaio_customsku')->__('Customer'),
            'value' => $customer->getName(),
        ));

        $productConfig = array(
            'input_name' => 'product',
            'input_label' => $this->__('Product'),
            'button_text' => $this->__('Select Product...'),
            'required' => true,
            'input_id' => 'entity_id'
        );

        $chooserHelper = Mage::helper('semaio_customsku/chooser');
        $chooserHelper->createProductChooser($product, $fieldset, $productConfig);

        $fieldset->addField('customsku2', 'text', array(
            'label' => Mage::helper('semaio_customsku')->__('Custom SKU'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'customsku',
            'value' => $customSku->getCustomSku(),
        ));

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
