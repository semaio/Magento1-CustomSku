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
 * Class Semaio_CustomSku_Block_Adminhtml_Customer_Edit_Tab_Customsku
 */
class Semaio_CustomSku_Block_Adminhtml_Customer_Edit_Tab_Customsku
    extends Semaio_CustomSku_Block_Adminhtml_Customer_Edit_CustomSku_Grid
        implements Mage_Adminhtml_Block_Widget_Tab_Interface

{

    /**
     * Semaio_CustomSku_Block_Adminhtml_Customer_Edit_Tab_Customsku constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('customer_edit_tab_customsku');
    }

    /**
     * Return Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Custom SKUs');
    }

    /**
     * Return Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Custom SKUs');
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        $customer = Mage::registry('current_customer');
        return (bool)$customer->getId();
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }
}