<?php
class Firegento_AdminLogger_Model_Observer_Model_Delete extends Firegento_AdminLogger_Model_Observer_Model_Abstract {
    /**
     * @param Varien_Event_Observer $observer
     */
    public function modelDeleteAfter(Varien_Event_Observer $observer) {
        $this->storeByObserver($observer);
    }

    /**
     * @return int
     */
    protected function getAction() {
        return Firegento_AdminLogger_Helper_Data::ACTION_DELETE;
    }
}