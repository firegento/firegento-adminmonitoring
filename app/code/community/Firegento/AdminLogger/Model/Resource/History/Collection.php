<?php

class Firegento_AdminLogger_Model_Resource_History_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('firegento_adminlogger/history');
    }
}