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
 * Class FireGento_AdminMonitoring_Test_Model_History_Diff
 *
 * @group FireGento_AdminMonitoring
 */
class FireGento_AdminMonitoring_Test_Model_History_Diff extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var FireGento_AdminMonitoring_Model_History_Diff
     */
    protected $_model;

    /**
     * Set up test class
     */
    protected function setUp()
    {
        parent::setUp();

        $dataModel = Mage::getModel('firegento_adminmonitoring/history_data', Mage::getModel('cms/page'));
        $this->_model = Mage::getModel('firegento_adminmonitoring/history_diff', $dataModel);
    }

    /**
     * Test model instance
     */
    public function testInstance()
    {
        $this->assertInstanceOf(
            'FireGento_AdminMonitoring_Model_History_Diff',
            $this->_model
        );
    }

    /**
     * @test
     * @loadFixture historyDiffCmsPage
     */
    public function hasChanged()
    {
        $model = $this->_getModel();
        $this->assertTrue($model->hasChanged());
    }

    /**
     * @test
     * @loadFixture historyDiffCmsPage
     */
    public function getSerializedDiff()
    {
        $model = $this->_getModel();
        $this->assertEquals('{"title":"Foo Baz","is_active":0}', $model->getSerializedDiff());
    }

    /**
     * Retrieve the changed model
     *
     * @return FireGento_AdminMonitoring_Model_History_Diff
     */
    protected function _getModel()
    {
        $page = Mage::getModel('cms/page')->load(99);
        $page->setOrigData('title', 'Foo Baz');
        $page->setOrigData('is_active', 0);

        $dataModel = Mage::getModel('firegento_adminmonitoring/history_data', $page);

        return Mage::getModel('firegento_adminmonitoring/history_diff', $dataModel);
    }
}
