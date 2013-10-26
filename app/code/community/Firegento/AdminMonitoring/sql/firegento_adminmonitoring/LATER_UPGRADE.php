<?php

// THIS FILE ADDS THE SCOPE TO THE LOG TABLE
// AT THE MOMENT WE DON'T USE IT
// SO THE VERSION IS 1.0.0 AND THEREFORE THIS
// SETUP IS NOT PERFORMED!


/* @var $installer Mage_Core_Model_Resource_Setup */

$installer = $this;

$installer
    ->getConnection()
    ->addColumn(
        $installer->getTable('firegento_adminmonitoring/firegento_adminmonitoring'),
        'scope',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        1,
        array(
             'unsigned' => true,
             'nullable' => true,
             'default'  => null,
        ),
        'scope of the change'
    )
    ->addColumn(
        $installer->getTable('firegento_adminmonitoring/firegento_adminmonitoring'),
        'scope_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        1,
        array(
             'unsigned' => true,
             'nullable' => true,
             'default'  => null,
        ),
        'id of the scope (store_id, group_id, website_id)'
    );
