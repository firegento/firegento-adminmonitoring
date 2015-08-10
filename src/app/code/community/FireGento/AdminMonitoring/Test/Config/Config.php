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
 * Class FireGento_AdminMonitoring_Test_Config_Config
 *
 * @group FireGento_AdminMonitoring
 */
class FireGento_AdminMonitoring_Test_Config_Config extends EcomDev_PHPUnit_Test_Case_Config
{
    /**
     * @test
     * @loadExpections
     */
    public function globalConfig()
    {
        $this->assertModuleVersion($this->expected('module')->getVersion());
        $this->assertModuleCodePool($this->expected('module')->getCodePool());

        $this->assertSetupResourceDefined();
        $this->assertSetupResourceExists();
        $this->assertSetupScriptVersions();

        $this->assertTableAlias('firegento_adminmonitoring/history', 'firegento_adminmonitoring_history');
    }

    /**
     * @test
     */
    public function testClassAliases()
    {
        /*
         * BLOCKS
         */

        $this->assertBlockAlias(
            'firegento_adminmonitoring/adminhtml_history',
            'FireGento_AdminMonitoring_Block_Adminhtml_History'
        );
        $this->assertBlockAlias(
            'firegento_adminmonitoring/adminhtml_history_grid',
            'FireGento_AdminMonitoring_Block_Adminhtml_History_Grid'
        );
        $this->assertBlockAlias(
            'firegento_adminmonitoring/adminhtml_history_grid_link',
            'FireGento_AdminMonitoring_Block_Adminhtml_History_Grid_Link'
        );
        $this->assertBlockAlias(
            'firegento_adminmonitoring/adminhtml_history_view',
            'FireGento_AdminMonitoring_Block_Adminhtml_History_View'
        );
        $this->assertBlockAlias(
            'firegento_adminmonitoring/adminhtml_history_view_detail',
            'FireGento_AdminMonitoring_Block_Adminhtml_History_View_Detail'
        );

        /*
         * HELPERS
         */

        $this->assertHelperAlias(
            'firegento_adminmonitoring',
            'FireGento_AdminMonitoring_Helper_Data'
        );

        /*
         * MODELS
         */

        $this->assertModelAlias(
            'firegento_adminmonitoring/history_data',
            'FireGento_AdminMonitoring_Model_History_Data'
        );
        $this->assertModelAlias(
            'firegento_adminmonitoring/history_diff',
            'FireGento_AdminMonitoring_Model_History_Diff'
        );
        $this->assertModelAlias(
            'firegento_adminmonitoring/observer_model_delete',
            'FireGento_AdminMonitoring_Model_Observer_Model_Delete'
        );
        $this->assertModelAlias(
            'firegento_adminmonitoring/observer_model_save',
            'FireGento_AdminMonitoring_Model_Observer_Model_Save'
        );
        $this->assertModelAlias(
            'firegento_adminmonitoring/observer_product_attribute_update',
            'FireGento_AdminMonitoring_Model_Observer_Product_Attribute_Update'
        );
        $this->assertModelAlias(
            'firegento_adminmonitoring/observer_product_import',
            'FireGento_AdminMonitoring_Model_Observer_Product_Import'
        );
        $this->assertModelAlias(
            'firegento_adminmonitoring/observer_log',
            'FireGento_AdminMonitoring_Model_Observer_Log'
        );
        $this->assertModelAlias(
            'firegento_adminmonitoring/observer_login',
            'FireGento_AdminMonitoring_Model_Observer_Login'
        );
        $this->assertModelAlias(
            'firegento_adminmonitoring/rowUrl_model_order',
            'FireGento_AdminMonitoring_Model_RowUrl_Model_Order'
        );
        $this->assertModelAlias(
            'firegento_adminmonitoring/rowUrl_model_page',
            'FireGento_AdminMonitoring_Model_RowUrl_Model_Page'
        );
        $this->assertModelAlias(
            'firegento_adminmonitoring/rowUrl_model_product',
            'FireGento_AdminMonitoring_Model_RowUrl_Model_Product'
        );
        $this->assertModelAlias(
            'firegento_adminmonitoring/system_config_source_admin_user',
            'FireGento_AdminMonitoring_Model_System_Config_Source_Admin_User'
        );
        $this->assertModelAlias(
            'firegento_adminmonitoring/system_config_source_history_action',
            'FireGento_AdminMonitoring_Model_System_Config_Source_History_Action'
        );
        $this->assertModelAlias(
            'firegento_adminmonitoring/system_config_source_history_status',
            'FireGento_AdminMonitoring_Model_System_Config_Source_History_Status'
        );
        $this->assertModelAlias(
            'firegento_adminmonitoring/clean',
            'FireGento_AdminMonitoring_Model_Clean'
        );
        $this->assertModelAlias(
            'firegento_adminmonitoring/config',
            'FireGento_AdminMonitoring_Model_Config'
        );
        $this->assertModelAlias(
            'firegento_adminmonitoring/history',
            'FireGento_AdminMonitoring_Model_History'
        );

        /*
         * RESOURCE MODELS
         */

        $this->assertResourceModelAlias(
            'firegento_adminmonitoring/history',
            'FireGento_AdminMonitoring_Model_Resource_History'
        );
        $this->assertResourceModelAlias(
            'firegento_adminmonitoring/history_collection',
            'FireGento_AdminMonitoring_Model_Resource_History_Collection'
        );
    }
}
