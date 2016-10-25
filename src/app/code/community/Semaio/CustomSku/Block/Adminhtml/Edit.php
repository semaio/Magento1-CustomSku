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
 * Class Semaio_CustomSku_Block_Adminhtml_Edit
 */
class Semaio_CustomSku_Block_Adminhtml_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Semaio_CustomSku_Block_Adminhtml_Edit constructor.
     */
    public function __construct()
    {
        $this->_headerText = Mage::helper('semaio_customsku')->__('Custom SKUs');
        $this->_objectId = 'customer_id';
        $this->_controller = 'customsku';
        parent::__construct();
        $this->_removeButton('delete');
    }

    /**
     * Inject the form into the layout
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        $this->setChild(
            'form',
            $this->getLayout()->createBlock('semaio_customsku/adminhtml_edit_form', 'semaio.customsku.edit.form')
        );

        return parent::_prepareLayout();
    }

    /**
     * Retrieve the back url
     *
     * @return string
     */
    public function getBackUrl()
    {
        $customerId = Mage::registry('current_customer')->getId();
        return $this->getUrl('*/customer/edit', array('id' => $customerId, 'active_tab' => 'customsku'));
    }

    /**
     * Retrieve the delete url
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', array($this->_objectId => $this->getRequest()->getParam($this->_objectId)));
    }
}
