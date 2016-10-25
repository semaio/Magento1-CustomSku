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
 * Class Semaio_CustomSku_Block_Adminhtml_Customer_Edit_CustomSku_Grid
 */
class Semaio_CustomSku_Block_Adminhtml_Customer_Edit_CustomSku_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Set grid params
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('semaio_customsku');
        $this->setDefaultSort('id');
    }

    /**
     * Put 'add' button for entity creation before grid output
     *
     * @param  string $html HTML
     * @return string
     */
    protected function _afterToHtml($html)
    {
        $customerId = Mage::registry('current_customer')->getId();

        return $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'id' => 'add_customsku',
                'label' => Mage::helper('semaio_customsku')->__('Add Custom SKU'),
                'class' => 'add content-header',
                'onclick' => "setLocation('{$this->getUrl('*/customsku/edit', array('customer_id' => $customerId))}')",
            ))->toHtml() . $html;
    }

    /**
     * Prepare collection for grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('semaio_customsku/customSku_collection')
            ->addFieldToFilter('customer_id', Mage::registry('current_customer')->getId())
            ->setOrder('id');

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Add columns to grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header' => Mage::helper('semaio_customsku')->__('ID'),
            'index' => 'id',
            'width' => '100px',
            'type' => 'text'
        ));

        $this->addColumn('sku', array(
            'header' => Mage::helper('semaio_customsku')->__('Sku'),
            'index' => 'sku',
            'type' => 'text'
        ));

        $this->addColumn('custom_sku', array(
            'header' => Mage::helper('semaio_customsku')->__('Custom SKU'),
            'index' => 'custom_sku',
            'type' => 'text',
            'escape' => true
        ));

        return parent::_prepareColumns();
    }

    /**
     * Prepare the massaction block
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');

        $this->getMassactionBlock()->setFormFieldName('customsku');
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('semaio_customsku')->__('Delete'),
            'url' => $this->getUrl('*/customsku/massDelete')
        ));

        return parent::_prepareMassaction();
    }

    /**
     * Retrieve the row url
     *
     * @param  Varien_Object $item Model
     * @return string
     */
    public function getRowUrl($item)
    {
        $customerId = Mage::registry('current_customer')->getId();
        return $this->getUrl('*/customsku/edit', array('customer_id' => $customerId, 'customsku_id' => $item->getId()));
    }
}
