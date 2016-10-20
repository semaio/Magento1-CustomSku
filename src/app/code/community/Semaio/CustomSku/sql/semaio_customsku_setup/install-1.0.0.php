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
 * Setup script
 */

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

// Retrieve the custom sku table name
$tableName = $installer->getTable('semaio_customsku/customsku');

// Drop table if it already exists
if ($installer->getConnection()->isTableExists($tableName)) {
    $installer->getConnection()->dropTable($tableName);
}

// Add new table
$table = $installer->getConnection()->newTable($tableName)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'primary'  => true,
        'identity' => true,
        'nullable' => false,
        'unsigned' => true
    ), 'ID')
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Entity Id')
    ->addColumn('sku', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Name')
    ->addColumn('custom_sku', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Name')
    ->addForeignKey(
        $installer->getFkName('semaio_customsku/customsku', 'customer_id', 'customer/entity', 'entity_id'),
        'customer_id',
        $installer->getTable('customer/entity'),
        'entity_id',
        Varien_Db_Adapter_Interface::FK_ACTION_CASCADE,
        Varien_Db_Adapter_Interface::FK_ACTION_CASCADE
    )
    ->addIndex(
        $installer->getIdxName(
            'semaio_customsku/customsku',
            array('customer_id', 'sku'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('customer_id', 'sku'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    )
    ->setComment('Semaio CustomSku Table');
$installer->getConnection()->createTable($table);


// Add custom_sku field to quote items table
$quoteItemTableName = $installer->getTable('sales/quote_item');
$installer->getConnection()->addColumn(
    $quoteItemTableName,
    'custom_sku',
    array(
        'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'  => 255,
        'comment' => 'Custom SKU'
    )
);

// Add custom_sku field to order items table
$orderItemTableName = $installer->getTable('sales/order_item');
$installer->getConnection()->addColumn(
    $orderItemTableName,
    'custom_sku',
    array(
        'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'  => 255,
        'comment' => 'Custom SKU'
    )
);

$installer->endSetup();
