<?php
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer = $this;

$installer->getConnection()->addIndex(
    $installer->getTable('firegento_adminlogger/history'),
    $installer->getConnection()->getIndexName(
        $installer->getTable('firegento_adminlogger/history'),
        array(
             'object_type', 'object_id'
        ),
        Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
    ),
    $installer->getTable('firegento_adminlogger/history'),
    array(
         'object_type', 'object_id'
    ),
    Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
);