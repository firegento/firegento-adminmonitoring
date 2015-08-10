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
 * Class FireGento_AdminMonitoring_Test_Model_RowUrl_Model_Customer
 *
 * @group FireGento_AdminMonitoring
 */
class FireGento_AdminMonitoring_Test_Model_RowUrl_Model_Customer extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * @var FireGento_AdminMonitoring_Model_RowUrl_Model_Customer
     */
    protected $_model;

    /**
     * Set up test class
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_model = Mage::getModel('firegento_adminmonitoring/rowUrl_model_customer');
    }

    /**
     * Test model instance
     */
    public function testInstance()
    {
        $this->assertInstanceOf(
            'FireGento_AdminMonitoring_Model_RowUrl_Model_Customer',
            $this->_model
        );
        $this->assertInstanceOf(
            'FireGento_AdminMonitoring_Model_RowUrl_Model_Abstract',
            $this->_model
        );
    }

    /**
     * @test
     * @loadFixture ~FireGento_AdminMonitoring/default
     */
    public function setRowUrl()
    {
        $history = Mage::getModel('firegento_adminmonitoring/history')->load(6);

        $transport = new Varien_Object();

        $observer = new Varien_Event_Observer();
        $event = new Varien_Event();
        $event->setData('history', $history);
        $event->setData('transport', $transport);
        $observer->setEvent($event);
        $observer->setData('history', $history);
        $observer->setData('transport', $transport);

        $this->_model->setRowUrl($observer);

        $this->assertContains('customer/edit/id/1/', $transport->getRowUrl());
    }
}
