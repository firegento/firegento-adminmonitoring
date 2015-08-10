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
 * Class FireGento_AdminMonitoring_Test_Model_History
 *
 * @group FireGento_AdminMonitoring
 */
class FireGento_AdminMonitoring_Test_Model_History extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var FireGento_AdminMonitoring_Model_History
     */
    protected $_model;

    /**
     * Set up test class
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_model = Mage::getModel('firegento_adminmonitoring/history');
    }

    /**
     * Test model instance
     */
    public function testInstance()
    {
        $this->assertInstanceOf(
            'FireGento_AdminMonitoring_Model_History',
            $this->_model
        );
    }

    /**
     * @test
     * @loadFixture ~FireGento_AdminMonitoring/default
     */
    public function getOriginalModel()
    {
        $model = $this->_model->load(2);
        $this->assertInstanceOf(
            'Mage_Cms_Model_Page',
            $model->getOriginalModel()
        );
        $this->assertEquals(1, $model->getOriginalModel()->getId());
    }

    /**
     * @test
     * @loadFixture ~FireGento_AdminMonitoring/default
     */
    public function getDecodedContentDiff()
    {
        $model = $this->_model->load(2);
        $this->assertEquals(
            array('content_heading' => 'foo baz'),
            $model->getDecodedContentDiff()
        );
    }

    /**
     * @test
     * @loadFixture ~FireGento_AdminMonitoring/default
     */
    public function getDecodedContent()
    {
        $model = $this->_model->load(2);
        $this->assertEquals(
            array('content_heading' => 'foo bar'),
            $model->getDecodedContent()
        );
    }

    /**
     * @test
     * @loadFixture ~FireGento_AdminMonitoring/default
     */
    public function isInsert()
    {
        $model = $this->_model->load(1);
        $this->assertTrue($model->isInsert());
    }

    /**
     * @test
     * @loadFixture ~FireGento_AdminMonitoring/default
     */
    public function isUpdate()
    {
        $model = $this->_model->load(2);
        $this->assertTrue($model->isUpdate());
    }

    /**
     * @test
     * @loadFixture ~FireGento_AdminMonitoring/default
     */
    public function isDelete()
    {
        $model = $this->_model->load(3);
        $this->assertTrue($model->isDelete());
    }

    /**
     * @test
     * @loadFixture ~FireGento_AdminMonitoring/default
     */
    public function isLogin()
    {
        $model = $this->_model->load(4);
        $this->assertTrue($model->isLogin());
    }
}
