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
 * PHPUnit Test
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Test_Config_Setup extends EcomDev_PHPUnit_Test_Case_Config
{
    /**
     * Test setup scripts
     */
    public function testSetupScripts()
    {
        $this->assertSetupResourceDefined();
        $this->assertSetupResourceExists();
    }

    /**
     * Test module version and code pool
     */
    public function testModuleVersion()
    {
        $this->assertModuleCodePool('community');
        $this->assertModuleVersion('1.0.3');
    }

    /**
     * Test model names
     */
    public function testModelNames()
    {
        $this->assertModelAlias('firegento_adminmonitoring/history', 'FireGento_AdminMonitoring_Model_History');
    }

    /**
     * Test helper names
     */
    public function testHelperNames()
    {
        $this->assertHelperAlias('firegento_adminmonitoring', 'FireGento_AdminMonitoring_Helper_Data');
    }

    /**
     * Test resource names
     */
    public function testResourceName()
    {
        $this->assertResourceModelAlias(
            'firegento_adminmonitoring/history', 'FireGento_AdminMonitoring_Model_Resource_History'
        );
        $this->assertResourceModelAlias(
            'firegento_adminmonitoring/history_collection', 'FireGento_AdminMonitoring_Model_Resource_History_Collection'
        );
    }

    /**
     * Test if database table exists
     */
    public function testTableExists()
    {
        $this->assertTableAlias('firegento_adminmonitoring/history', 'firegento_adminmonitoring_history');
    }
}
