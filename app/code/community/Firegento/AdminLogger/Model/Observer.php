<?php
class Firegento_AdminLogger_Model_Observer {
    const XML_PATH_ADMINLOGGER_CLEAN_ENABLED = 'admin/firegento_adminlogger/enable_cleaning';

    /**
     * Cleaning Database Entries
     *
     * @param Mage_Cron_Model_Schedule $schedule
     */
    public function scheduledCleanAdminLogger (Mage_Cron_Model_Schedule $schedule) {

        if (!Mage::getStoreConfigFlag(self::XML_PATH_ADMINLOGGER_CLEAN_ENABLED)) {
            return $this;
        }

        try {
            Mage::getModel('firegento_adminlogger/clean')->clean();
        }
        catch (Exception $e) {
            Mage::logException($e);
        }
    }
}