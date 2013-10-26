<?php
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer = $this;

$installer->getConnection()->addIndex(
    $installer->getTable('firegento_adminmonitoring/history'),
    $installer->getConnection()->getIndexName(
        $installer->getTable('firegento_adminmonitoring/history'),
        array(
             'object_type', 'object_id'
        ),
        Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
    ),
    array(
         'object_type', 'object_id'
    ),
    Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
);

$installer->getConnection()->changeColumn(
    $installer->getTable('firegento_adminmonitoring/history'),
    'data',
    'content',
    array(
         'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
         'size'    => null,
         'comment' => 'data of changed entity'
    )
);

$installer->getConnection()->addColumn(
    $installer->getTable('firegento_adminmonitoring/history'),
    'content_diff',
    array(
         'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
         'size'    => null,
         'comment' => 'changed data of entity'
    )
);
