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
 * Class FireGento_AdminMonitoring_Test_Model_History_Data
 *
 * @group FireGento_AdminMonitoring
 */
class FireGento_AdminMonitoring_Test_Model_History_Data extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var FireGento_AdminMonitoring_Model_History_Data
     */
    protected $_model;

    /**
     * Set up test class
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_model = Mage::getModel('firegento_adminmonitoring/history_data', Mage::getModel('cms/page'));
    }

    /**
     * Test model instance
     */
    public function testInstance()
    {
        $this->assertInstanceOf(
            'FireGento_AdminMonitoring_Model_History_Data',
            $this->_model
        );
    }

    /**
     * @test
     * @loadFixture historyDataCmsPage
     */
    public function getSerializedContent()
    {
        $model = $this->_getModel();
        $serializedContent = $model->getSerializedContent();
        $this->assertContains('"title":"Foo Baz"', $serializedContent);
    }

    /**
     * @test
     * @loadFixture historyDataCmsPage
     */
    public function getContent()
    {
        $model = $this->_getModel();
        $content = $model->getContent();
        $this->assertGreaterThan(0, count($content));
        $this->assertTrue(isset($content['title']));
        $this->assertEquals('Foo Baz', $content['title']);
    }

    /**
     * @test
     * @loadFixture historyDataCmsPage
     */
    public function getOrigContent()
    {
        $model = $this->_getModel();
        $origContent = $model->getOrigContent();
        $this->assertGreaterThan(0, count($origContent));
        $this->assertTrue(isset($origContent['title']));
        $this->assertEquals('Foo Baz', $origContent['title']);
    }

    /**
     * @test
     */
    public function getObjectType()
    {
        $object = new Mage_Cms_Model_Page();

        /** @var FireGento_AdminMonitoring_Model_History_Data $model */
        $model  = Mage::getModel('firegento_adminmonitoring/history_data', $object);

        $this->assertEquals('Mage_Cms_Model_Page', $model->getObjectType());
    }

    /**
     * @test
     * @loadFixture historyDataCmsPage
     */
    public function getObjectId()
    {
        $model = $this->_getModel();
        $this->assertEquals(99, $model->getObjectId());
    }

    /**
     * Retrieve the changed model
     *
     * @return FireGento_AdminMonitoring_Model_History_Data
     */
    protected function _getModel()
    {
        $page = Mage::getModel('cms/page')->load(99);

        return Mage::getModel('firegento_adminmonitoring/history_data', $page);
    }
}
