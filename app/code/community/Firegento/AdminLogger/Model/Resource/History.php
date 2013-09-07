<?php
class Firegento_AdminLogger_Model_Resource_History extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('firegento_adminlogger/history', 'history_id');
    }

}