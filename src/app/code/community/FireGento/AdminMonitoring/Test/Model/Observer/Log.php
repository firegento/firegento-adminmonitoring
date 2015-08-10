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
 * Class FireGento_AdminMonitoring_Test_Model_Observer_Log
 *
 * @group FireGento_AdminMonitoring
 */
class FireGento_AdminMonitoring_Test_Model_Observer_Log extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * @var FireGento_AdminMonitoring_Model_Observer_Log
     */
    protected $_model;

    /**
     * Set up test class
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_model = Mage::getModel('firegento_adminmonitoring/observer_log');
    }

    /**
     * Test model instance
     */
    public function testInstance()
    {
        $this->assertInstanceOf(
            'FireGento_AdminMonitoring_Model_Observer_Log',
            $this->_model
        );
    }

    /**
     * @test
     * @loadFixture ~FireGento_AdminMonitoring/default
     */
    public function getUserId()
    {
        $this->_mockAdminSession();
        $this->assertEquals(1, $this->_model->getUserId());
    }

    /**
     * @test
     * @loadFixture ~FireGento_AdminMonitoring/default
     */
    public function getUserName()
    {
        $this->_mockAdminSession();
        $this->assertEquals('admin', $this->_model->getUserName());
    }

    /**
     * @test
     * @loadFixture ~FireGento_AdminMonitoring/default
     */
    public function getUser()
    {
        $this->_mockAdminSession();
        $this->assertInstanceOf(
            'Mage_Admin_Model_User',
            $this->_model->getUser()
        );
    }

    /**
     * @test
     */
    public function getRemoteAddr()
    {
        $helperMock = $this->getHelperMock('core/http', array('getRemoteAddr'));
        $helperMock->expects($this->any())
            ->method('getRemoteAddr')
            ->will($this->returnValue('8.8.8.8'));
        $this->replaceByMock('helper', 'core/http', $helperMock);

        $this->assertEquals('8.8.8.8', $this->_model->getRemoteAddr());
    }

    /**
     * Mock an admin session with returning the same admin user
     */
    protected function _mockAdminSession()
    {
        $adminUser = Mage::getModel('admin/user')->load(1);

        $sessionMock = $this->getModelMock('admin/session', array('getUser'));
        $sessionMock->expects($this->any())
            ->method('getUser')
            ->will($this->returnValue($adminUser));
        $this->replaceByMock('singleton', 'admin/session', $sessionMock);
    }
}
