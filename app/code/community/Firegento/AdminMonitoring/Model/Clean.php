<?php
class Firegento_AdminMonitoring_Model_Clean {

    const XML_PATH_ADMINMONITORING_INTERVAL = 'admin/firegento_adminmonitoring/interval';
    const XML_PATH_ADMINMONITORING_CLEAN_ENABLED = 'admin/firegento_adminmonitoring/enable_cleaning';

    /**
     * Cleaning database-table
     *
     * @return Firegento_AdminMonitoring_Model_Clean
     */
    public function clean () {
        if (!Mage::getStoreConfigFlag(self::XML_PATH_ADMINMONITORING_INTERVAL)) {
            return $this;
        }

        if (Mage::getStoreConfig(self::XML_PATH_ADMINMONITORING_CLEAN_ENABLED)) {

            $interval = Mage::getStoreConfig(self::XML_PATH_ADMINMONITORING_INTERVAL);

            /** @var $adminMonitoringCollection Firegento_AdminMonitoring_Model_Resource_History_Collection */
            $adminMonitoringCollection = Mage::getModel('firegento_adminmonitoring/history')
                ->getCollection()
                ->addFieldToFilter('created_at', array(
                'lt' => new Zend_Db_Expr("DATE_SUB('" . now() . "', INTERVAL " . (int)$interval . " DAY)")));

            foreach ($adminMonitoringCollection as $history) {
                $history->delete();
            }
        }
        return $this;
    }
}