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
 * Class Semaio_CustomSku_Helper_Chooser
 *
 * Based on https://github.com/SessionDE/Jarlssen_ChooserWidget
 */
class Semaio_CustomSku_Helper_Chooser extends Mage_Core_Helper_Abstract
{
    const PRODUCT_CHOOSER_BLOCK_ALIAS = 'adminhtml/catalog_product_widget_chooser';

    protected $_requiredConfigValues = array('input_name');

    /**
     * Wrapper function, that creates product chooser button in the
     * generic Mage Admin forms
     *
     * @param  Mage_Core_Model_Abstract          $dataModel Model
     * @param  Varien_Data_Form_Element_Fieldset $fieldset  Fieldset
     * @param  array                             $config    Config
     * @return Semaio_CustomSku_Helper_Chooser
     */
    public function createProductChooser($dataModel, $fieldset, $config)
    {
        $blockAlias = self::PRODUCT_CHOOSER_BLOCK_ALIAS;
        $this->_prepareChooser($dataModel, $fieldset, $config, $blockAlias);
        return $this;
    }

    /**
     * Wrapper function, that creates custom chooser button in the
     * generic Mage Admin forms
     *
     * @param  Mage_Core_Model_Abstract          $dataModel  Model
     * @param  Varien_Data_Form_Element_Fieldset $fieldset   Fieldset
     * @param  array                             $config     Config
     * @param  string                            $blockAlias Block Alias
     * @return Semaio_CustomSku_Helper_Chooser
     */
    public function createChooser($dataModel, $fieldset, $config, $blockAlias)
    {
        $this->_prepareChooser($dataModel, $fieldset, $config, $blockAlias);
        return $this;
    }

    /**
     * This function is actually some kind of workaround how to create
     * a chooser and to reuse the product chooser widget.
     *
     * Most of the code was created after some reverse engineering of these 2 classes:
     *  - Mage_Widget_Block_Adminhtml_Widget_Options
     *  - Mage_Adminhtml_Block_Catalog_Product_Widget_Chooser
     *
     * So there are interesting ideas of the Magento Core Team in these 2 classes:
     *  - Mage_Widget_Block_Adminhtml_Widget_Options
     *  -- Here they extend Mage_Adminhtml_Block_Widget_Form and do some tricks in:
     *  --- _prepareForm
     *  --- addFields and _addField
     *
     *  - Mage_Adminhtml_Block_Catalog_Product_Widget_Chooser
     *  -- Here they attach the chooser html in the property after_element_html
     *  -- also they add some js methods, that control the behaviour of the chooser button
     *     and the the behaviour of the products grid that appear after the the button is pressed.
     *
     * The ideas in the both classes are interesting and this is a good example how we
     * can reuse core components.
     *
     * !!! The best solution would be to create our class that extends Mage_Adminhtml_Block_Widget_Form
     * and to do similar tricks that they do in Mage_Widget_Block_Adminhtml_Widget_Options
     * So we can reuse this class for the forms, that we need different kind of choosers.
     * Right now we can't reuse their Mage_Widget_Block_Adminhtml_Widget_Options, because there
     * are too many dependencies of the widget config and this class can't be reused easy out of the widget context.
     *
     * Also it was needed to include some extra JS files by layout update: <update handle="editor"/>
     * In favour to fire the choose grid after the choose button is pressed.
     *
     * @param  Mage_Core_Model_Abstract          $dataModel  Model
     * @param  Varien_Data_Form_Element_Fieldset $fieldset   Fieldset
     * @param  array                             $config     Config
     * @param  string                            $blockAlias Block Alias
     * @return Semaio_CustomSku_Helper_Chooser
     */
    protected function _prepareChooser($dataModel, $fieldset, $config, $blockAlias)
    {
        $chooserConfigData = $this->_prepareChooserConfig($config, $blockAlias);
        $chooserBlock = Mage::app()->getLayout()->createBlock($blockAlias, '', $chooserConfigData);

        $element = $this->_createFormElement($dataModel, $fieldset, $config);

        $chooserBlock
            ->setConfig($chooserConfigData)
            ->setFieldsetId($fieldset->getId())
            ->prepareElementHtml($element);

        return $this;
    }

    /**
     * Creates label form element and sets empty value of
     * the hidden input, that is created, when we have form element
     * from type label
     *
     * @param  Mage_Core_Model_Abstract          $dataModel Model
     * @param  Varien_Data_Form_Element_Fieldset $fieldset  Fieldset
     * @param  array                             $config    Config
     * @return Varien_Data_Form_Element_Abstract
     */
    protected function _createFormElement($dataModel, $fieldset, $config)
    {
        $isRequired = (isset($config['required']) && true === $config['required']) ? true : false;

        $inputConfig = array(
            'name' => $config['input_name'],
            'label' => $config['input_label'],
            'required' => $isRequired
        );

        if (!isset($config['input_id'])) {
            $config['input_id'] = $config['input_name'];
        }

        $element = $fieldset->addField($config['input_id'], 'label', $inputConfig);

        /*
         *  add '/', so init value will fit for expected format: product/[id]
         *  we just have id, since we just store item's SKU
         */

        if ($id = $dataModel->getData($element->getId())) {
            $element->setValue($element->getName() . '/' . $id);
            $dataModel->setData($element->getId(), '');
        }

        return $element;
    }

    /**
     * Prepare config in format, that is needed for the chooser "factory"
     *
     * @param  array  $config     Config
     * @param  string $blockAlias Block Alias
     * @return array
     */
    protected function _prepareChooserConfig($config, $blockAlias)
    {
        return array(
            'button' => array(
                'open' => $config['button_text'],
                'type' => $blockAlias
            )
        );
    }
}
