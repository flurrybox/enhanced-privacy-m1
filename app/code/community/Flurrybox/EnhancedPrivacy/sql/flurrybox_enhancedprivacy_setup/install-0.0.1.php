<?php
/**
 * This file is part of the Flurrybox EnhancedPrivacy package.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Flurrybox EnhancedPrivacy
 * to newer versions in the future.
 *
 * @copyright Copyright (c) 2018 Flurrybox, Ltd. (https://flurrybox.com/)
 * @license   GNU General Public License ("GPL") v3.0
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$installer = $this;
$installer->startSetup();

/**
 * Table for delete reasons
 */
if (!$installer->tableExists('flurrybox_enhancedprivacy/reason')) {
    $table = $installer->getConnection()
        ->newTable($installer->getTable('flurrybox_enhancedprivacy/reason'))
        ->addColumn('reason_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, [
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true
        ], 'Status id')
        ->addColumn('reason', Varien_Db_Ddl_Table::TYPE_TEXT, null, [
            'nullable' => false
        ], 'Reason text')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
            'nullable' => false,
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT
        ], 'Created At');

    $installer->getConnection()->createTable($table);
}

/**
 * Delete schedule table
 */
if (!$installer->tableExists('flurrybox_enhancedprivacy/cleanup')) {
    $table = $installer->getConnection()
        ->newTable($installer->getTable('flurrybox_enhancedprivacy/cleanup'))
        ->addColumn('schedule_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, [
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true
        ], 'Id of schedule item')
        ->addColumn(
            'scheduled_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
            'nullable' => false,
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT
        ], 'Scheduled At')
        ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
            'nullable' => false
        ], 'Customer entity Id')
        ->addColumn('type', Varien_Db_Ddl_Table::TYPE_TEXT, 255, [
            'nullable' => false
        ], 'Action type')
        ->addColumn('reason', Varien_Db_Ddl_Table::TYPE_TEXT, null, [
            'nullable' => false
        ], 'Reason text')
        ->addIndex($installer->getIdxName(
            'flurrybox_enhancedprivacy/cleanup',
            ['customer_id'],
            true),
            ['customer_id'],
            ['type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE]
        );

    $installer->getConnection()->createTable($table);
}

/**
 * Customer attribute "Is Anonymized"
 */
$eavSetup = new Mage_Eav_Model_Entity_Setup('core_setup');
$eavSetup->addAttribute('customer', 'is_anonymized',  [
    'type'     => 'int',
    'backend'  => '',
    'label'    => 'Is Anonimyzed',
    'input'    => 'select',
    'source'   => 'eav/entity_attribute_source_boolean',
    'visible'  => true,
    'required' => false,
    'default'  => '',
    'frontend' => '',
    'unique'   => false,
    'note'     => ''
]);

$attribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'is_anonymized');

$used_in_forms = [
    'adminhtml_customer',
    'checkout_register',
    'customer_account_create',
    'customer_account_edit',
    'adminhtml_checkout'
];

$attribute->setData('used_in_forms', $used_in_forms)
    ->setData('is_used_for_customer_segment', true)
    ->setData('is_system', 0)
    ->setData('is_user_defined', 1)
    ->setData('is_visible', 1)
    ->setData('sort_order', 100);

$attribute->save();

$installer->endSetup();
