<?php
class Firegento_AdminLogger_Test_Config_Setup extends EcomDev_PHPUnit_Test_Case_Config
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
        $this->assertModelAlias('firegento_adminlogger/history', 'Firegento_AdminLogger_Model_History');
    }

    public function testHelperNames()
    {
        $this->assertHelperAlias('firegento_adminlogger', 'Firegento_AdminLogger_Helper_Data');
    }

    public function testResourceName()
    {
        $this->assertResourceModelAlias(
            'firegento_adminlogger/history', 'Firegento_AdminLogger_Model_Resource_History'
        );
        $this->assertResourceModelAlias(
            'firegento_adminlogger/history_collection', 'Firegento_AdminLogger_Model_Resource_History_Collection'
        );
    }

    public function testTableExists()
    {
        $this->assertTableAlias('firegento_adminlogger/history', 'firegento_adminlogger_history');
    }
}