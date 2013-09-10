<?php
class Firegento_AdminLogger_Model_Clean {

    const XML_PATH_ADMINLOGGER_INTERVAL = 'admin/firegento_adminlogger/interval';
    const XML_PATH_ADMINLOGGER_CLEAN_ENABLED = 'admin/firegento_adminlogger/enable_cleaning';

    /**
     * Cleaning database-table
     *
     * @return Firegento_AdminLogger_Model_Clean
     */
    public function clean () {
        if (!Mage::getStoreConfigFlag(self::XML_PATH_ADMINLOGGER_INTERVAL)) {
            return $this;
        }

        if (Mage::getStoreConfig(self::XML_PATH_ADMINLOGGER_CLEAN_ENABLED)) {

            $interval = Mage::getStoreConfig(self::XML_PATH_ADMINLOGGER_INTERVAL);

            /** @var $adminLoggerCollection Firegento_AdminLogger_Model_Resource_History_Collection */
            $adminLoggerCollection = Mage::getModel('firegento_adminlogger/history')
                ->getCollection()
                ->addFieldToFilter('created_at', array(
                'lt' => new Zend_Db_Expr("DATE_SUB('" . now() . "', INTERVAL " . (int)$interval . " DAY)")));

            foreach ($adminLoggerCollection as $history) {
                $history->delete();
            }
        }
        return $this;
    }
}