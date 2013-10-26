<?php
class Firegento_AdminMonitoring_Model_Resource_History extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('firegento_adminmonitoring/history', 'history_id');
    }

}