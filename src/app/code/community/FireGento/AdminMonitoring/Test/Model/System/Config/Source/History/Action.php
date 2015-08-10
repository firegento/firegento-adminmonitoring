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
 * Class FireGento_AdminMonitoring_Test_Model_System_Config_Source_History_Action
 *
 * @group FireGento_AdminMonitoring
 */
class FireGento_AdminMonitoring_Test_Model_System_Config_Source_History_Action extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var FireGento_AdminMonitoring_Model_System_Config_Source_History_Action
     */
    protected $_model;

    /**
     * Set up test class
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_model = Mage::getModel('firegento_adminmonitoring/system_config_source_history_action');
    }

    /**
     * Test model instance
     */
    public function testInstance()
    {
        $this->assertInstanceOf(
            'FireGento_AdminMonitoring_Model_System_Config_Source_History_Action',
            $this->_model
        );
        $this->assertInstanceOf(
            'FireGento_AdminMonitoring_Model_System_Config_Source_SourceAbstract',
            $this->_model
        );
    }

    /**
     * @test
     * @loadExpectations
     */
    public function toOptionArray()
    {
        $this->assertEquals(
            $this->expected('options')->getResult(),
            $this->_model->toOptionArray()
        );
    }

    /**
     * @test
     * @loadExpectations
     */
    public function toOptionHash()
    {
        $this->assertEquals(
            $this->expected('options')->getResult(),
            $this->_model->toOptionHash()
        );
    }
}
