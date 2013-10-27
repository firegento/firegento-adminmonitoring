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
 * @copyright 2013 FireGento Team (http://www.firegento.com)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 */
/**
 * PHPUnit Test
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Test_Model_Observer extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var FireGento_AdminMonitoring_Model_Observer_Model_Save
     */
    protected $_object;

    /**
     * Init model
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_object = Mage::getModel('firegento_adminmonitoring/observer_model_save');

        // set admin/session
        $this->_setAdminSession();
    }

    /**
     * set admin session with session
     */
    protected function _setAdminSession()
    {
        $sessionMock = $this->getModelMockBuilder('admin/session')
            ->disableOriginalConstructor() // This one removes session_start and other methods usage
            ->setMethods(null) // Enables original methods usage, because by default it overrides all methods
            ->getMock();
        $this->replaceByMock('singleton', 'admin/session', $sessionMock);
    }

    /**
     * Create event to pass into observer method
     *
     * @param array $data Observer Data
     * @return Varien_Event_Observer Observer Model
     */
    protected function _createObserver(array $data)
    {
        $event = new Varien_Event($data);
        $data['event'] = $event;
        $observer = new Varien_Event_Observer();
        return $observer->setData($data);
    }

    /**
     * if FireGento_AdminMonitoring_Model_History is saved, don't do anything inside the observer
     */
    public function testNoHistorySaves()
    {
        return $this; // @todo fix unit test

        $object = new FireGento_AdminMonitoring_Model_History();
        $data = array('object' => $object);
        $observer = $this->_createObserver($data);

        $mock = $this->getModelMock('firegento_adminmonitoring/history');
        $mock->expects($this->never())->method('save');
        $this->replaceByMock('model', 'firegento_adminmonitoring/history', $mock);

        $this->_object->modelAfter($observer);
    }

    /**
     * @dataProvider dataProvider
     * @loadExpectation
     * @loadFixture
     */
    public function testHistorySavesWithCustomer(
        $id, $mail = null, $firstname = null, $lastname = null, $password = null
    ) {
        return $this; // @todo fix unit test

        /* @var $customer Mage_Customer_Model_Customer */
        $customer = Mage::getModel('customer/customer');

        if ($id !== null) {
            $customer->load($id);
        }
        if (!empty($mail)) {
            $customer->setEmail($mail);
        }
        if (!empty($firstname)) {
            $customer->setFirstname($firstname);
        }
        if (!empty($lastname)) {
            $customer->setLastname($lastname);
        }
        if (!empty($password)) {
            $customer->setPasswordHash($password);
        }

        $data = array('object' => $customer);
        $observer = $this->_createObserver($data);

        $mock = $this->getModelMock('firegento_adminmonitoring/history', null);
        $mock->expects($this->once())->method('save');
        $this->replaceByMock('model', 'firegento_adminmonitoring/history', $mock);

        $this->_object->modelBefore($observer);
        $this->_object->modelAfter($observer);
        $data = $mock->getData();

        $this->assertRegExp('#^[0-9]*$#', $mock->getHistoryId());
        $this->assertRegExp(
            '/^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9]) (?:([0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?$/',
            $mock->getCreatedAt()
        );

        unset($data['created_at'], $data['history_id']); // remove changing attributes

        $this->assertEquals(
            $this->expected("$id-$mail-$firstname-$lastname-$password")->getData(),
            $data
        );
    }
}
