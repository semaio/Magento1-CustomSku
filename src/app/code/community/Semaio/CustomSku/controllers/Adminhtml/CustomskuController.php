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
 * Class Semaio_CustomSku_Adminhtml_CustomskuController
 */
class Semaio_CustomSku_Adminhtml_CustomskuController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Edit a custom SKU
     */
    public function editAction()
    {
        $customerId = (int)$this->getRequest()->getParam('customer_id');
        $customSkuId = (int)$this->getRequest()->getParam('customsku_id');

        Mage::register('current_customer', Mage::getModel('customer/customer')->load($customerId));
        $customSku = Mage::getModel('semaio_customsku/customSku')->load($customSkuId);
        Mage::register('current_customsku', $customSku);


        $this->_title($this->__('Custom SKU'));

        $this->loadLayout();

        $this->_setActiveMenu('customer/manage');

        $this->_initLayoutMessages('admin/session');

        $this->_addContent(
            $this->getLayout()->createBlock('semaio_customsku/adminhtml_edit', 'semaio.customsku.edit')
        );

        $this->renderLayout();
    }

    /**
     * Save a custom SKU
     */
    public function saveAction()
    {
        $data = $this->getRequest()->getPost();

        /*
         * Check for existing or new entity
         *
         */

        if ($data['id']) {
            try {
                $productId = str_replace('product/', '', $data['product']);
                $productSku = Mage::getModel('catalog/product')->load($productId)->getSku();

                $model = Mage::getModel('semaio_customsku/customSku')->load($data['id']);

                $model->setData('sku', $productSku);
                $model->setData('custom_sku', $data['customsku']);
                $model->save();

                $this->_getSession()->addSuccess(
                    $this->_getHelper()->__('Data successfully saved.')
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        } elseif ($data) {
            try {
                $productId = str_replace('product/', '', $data['product']);
                $productSku = Mage::getModel('catalog/product')->load($productId)->getSku();

                $model = Mage::getModel('semaio_customsku/customSku');
                $model->setData('customer_id', $data['customer_id']);
                $model->setData('sku', $productSku);
                $model->setData('custom_sku', $data['customsku']);
                $model->save();
            } catch (Exception $e) {
                $helper = $this->_getHelper();
                if ($e->getCode() == 23000) { // Duplicate key error
                    $this->_getSession()->addError(
                        $helper->__('You already have a custom sku for the sku "%s".', $model->getData('sku'))
                    );
                } else {
                    $helper->getSession()->addError($helper->__('Error during save. Please try again.'));
                }
            }
        }

        $this->_redirect('*/customer/edit', array('id' => $model->getData('customer_id'), 'active_tab' => 'customsku'));
    }

    /**
     * Mass delete custom SKUs
     */
    public function massDeleteAction()
    {
        $customSkuIds = $this->getRequest()->getParam('customsku');

        if (!is_array($customSkuIds)) {
            $this->_getSession()->addError($this->_getHelper()->__('Please select custom SKU(s)'));
        } else {
            try {
                foreach ($customSkuIds as $customSkuId) {
                    $customSku = Mage::getModel('semaio_customsku/customSku')->load($customSkuId);
                    $customerId = $customSku->getCustomerId(); // TODO: this is crap...
                    $customSku->delete();
                }
                $this->_getSession()->addSuccess(
                    $this->_getHelper()->__('Total of %d record(s) were deleted', count($customSkuIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }

        $this->_redirect('*/customer/edit', array('id' => $customerId, 'active_tab' => 'customsku'));
    }

    /**
     * Retrieve module's helper
     *
     * @return Mage_Core_Helper_Abstract
     */
    protected function _getHelper()
    {
        return Mage::helper('semaio_customsku');
    }

    /**
     * Retrieve customer session model
     *
     * @return Mage_Adminhtml_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('adminhtml/session');
    }

    /**
     * Check if editing the custom sku is allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('customer/manage');
    }
}
