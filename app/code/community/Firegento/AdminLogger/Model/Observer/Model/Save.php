<?php
class Firegento_AdminLogger_Model_Observer_Model_Save extends Firegento_AdminLogger_Model_Observer_Model_Abstract {
    /**
     * @param Varien_Event_Observer $observer
     */
    public function modelSaveAfter(Varien_Event_Observer $observer) {
        $this->storeByObserver($observer);
    }

    /**
     * @return bool
     */
    protected function hasChanged() {
        return (!$this->isUpdate() OR parent::hasChanged());
    }

    /**
     * @return bool
     */
    private function isUpdate () {
        return $this->getAction() == Firegento_AdminLogger_Helper_Data::ACTION_UPDATE;
    }

    /**
     * @var ont
     */
    private $modelSaveBeforeId;
    /**
     * @param Varien_Event_Observer $observer
     */
    public function modelSaveBefore(Varien_Event_Observer $observer) {
        /**
         * @var $savedObject Mage_Core_Model_Abstract
         */
        $savedObject = $observer->getObject();
        $this->modelSaveBeforeId = $savedObject->getId();
    }

    /**
     * @return int
     */
    protected function getAction() {
        if ($this->modelSaveBeforeId) {
            return Firegento_AdminLogger_Helper_Data::ACTION_UPDATE;
        } else {
            return Firegento_AdminLogger_Helper_Data::ACTION_INSERT;
        }
    }

}