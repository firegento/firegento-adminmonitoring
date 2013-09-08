<?php
class Firegento_AdminLogger_Model_Observer_Model_Delete extends Firegento_AdminLogger_Model_Observer_Model_Abstract {
    /**
     * @return int
     */
    protected function getAction() {
        return Firegento_AdminLogger_Helper_Data::ACTION_DELETE;
    }
}