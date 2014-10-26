<?php
/**
 * This file is part of a FireGento e.V. module.
 *
 * This FireGento e.V. module is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License version 3 as
 * published by the Free Software Foundation.
 *
 * This script is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * PHP version 5
 *
 * @category  FireGento
 * @package   FireGento_AdminMonitoring
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2014 FireGento Team (http://www.firegento.com)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 */
/**
 * Setup Script
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$logTable = $installer->getConnection()->newTable($installer->getTable('firegento_adminmonitoring/history'))
    ->addColumn(
        'history_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
             'identity' => true,
             'unsigned' => true,
             'nullable' => false,
             'primary'  => true,
        ),
        'Primary key of the log entry'
    )
    ->addColumn(
        'data',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(),
        'data of the changed entity'
    )
    ->addColumn(
        'user_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        1,
        array(
             'unsigned' => true,
             'nullable' => true,
             'default'  => null,
        ),
        'user_id of the admin user'
    )
    ->addColumn(
        'user_name',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(),
        'username of the admin user - to know which user it was after deletion'
    )
    ->addColumn(
        'ip',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(),
        'ip of the admin user'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_DATETIME,
        null,
        array(),
        'created at'
    )
    ->addColumn(
        'user_agent',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(),
        'user agent used by user'
    )
    ->addColumn(
        'action',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        1,
        array(
             'unsigned' => true,
             'nullable' => false,
        ),
        'action which is performed on the object'
    )
    ->addColumn(
        'object_type',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        255,
        array(),
        'class name of the changed type'
    )
    ->addColumn(
        'object_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
             'unsigned' => true,
             'nullable' => false,
        ),
        'id of the changed type'
    )
;

$installer->getConnection()->createTable($logTable);

$installer->endSetup();
