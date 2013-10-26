<?php
class Firegento_AdminMonitoring_Model_Observer {
    const XML_PATH_ADMINMONITORING_CLEAN_ENABLED = 'admin/firegento_adminmonitoring/enable_cleaning';

    /**
     * Cleaning Database Entries
     *
     * @param Mage_Cron_Model_Schedule $schedule
     */
    public function scheduledCleanAdminMonitoring (Mage_Cron_Model_Schedule $schedule) {

        if (!Mage::getStoreConfigFlag(self::XML_PATH_ADMINMONITORING_CLEAN_ENABLED)) {
            return $this;
        }

        try {
            Mage::getModel('firegento_adminmonitoring/clean')->clean();
        }
        catch (Exception $e) {
            Mage::logException($e);
        }
    }
}