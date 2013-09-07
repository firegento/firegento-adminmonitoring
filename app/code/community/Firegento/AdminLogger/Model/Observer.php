<?php
class Firegento_AdminLogger_Model_Observer {
    /**
     * @param Varien_Event_Observer $observer
     */
    public function modelSaveAfter(Varien_Event_Observer $observer) {
        Mage::log('model save after');
    }
}