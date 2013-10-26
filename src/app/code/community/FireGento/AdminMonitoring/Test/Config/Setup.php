<?php
class FireGento_AdminMonitoring_Test_Config_Setup extends EcomDev_PHPUnit_Test_Case_Config
{
    public function testSetupScripts()
    {
        $this->assertSetupResourceDefined();
        $this->assertSetupResourceExists();
    }

    public function testModuleVersion()
    {
        $this->assertModuleCodePool('community');
        $this->assertModuleVersionGreaterThanOrEquals('1.0.0');
    }

    public function testModelNames()
    {
        $this->assertModelAlias('firegento_adminmonitoring/history', 'FireGento_AdminMonitoring_Model_History');
    }

    public function testHelperNames()
    {
        $this->assertHelperAlias('firegento_adminmonitoring', 'FireGento_AdminMonitoring_Helper_Data');
    }

    public function testResourceName()
    {
        $this->assertResourceModelAlias(
            'firegento_adminmonitoring/history', 'FireGento_AdminMonitoring_Model_Resource_History'
        );
        $this->assertResourceModelAlias(
            'firegento_adminmonitoring/history_collection', 'FireGento_AdminMonitoring_Model_Resource_History_Collection'
        );
    }

    public function testTableExists()
    {
        $this->assertTableAlias('firegento_adminmonitoring/history', 'firegento_adminmonitoring_history');
    }
}
