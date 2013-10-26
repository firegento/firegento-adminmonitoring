<?php
class Firegento_AdminMonitoring_Model_Observer_Model_Delete extends Firegento_AdminMonitoring_Model_Observer_Model_Abstract {
    /**
     * @return int
     */
    protected function getAction() {
        return Firegento_AdminMonitoring_Helper_Data::ACTION_DELETE;
    }
}