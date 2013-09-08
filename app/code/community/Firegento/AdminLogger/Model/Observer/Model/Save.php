<?php
class Firegento_AdminLogger_Model_Observer_Model_Save extends Firegento_AdminLogger_Model_Observer_Model_Abstract {

    private $currentHash;

    /**
     * @param Varien_Event_Observer $observer
     */
    public function modelAfter(Varien_Event_Observer $observer) {
        $this->storeCurrentHash($observer->getObject());
        parent::modelAfter($observer);
    }

    /**
     * @param Mage_Core_Model_Abstract $model
     */
    private function storeCurrentHash(Mage_Core_Model_Abstract $model) {
        $this->currentHash = $this->getObjectHash($model);
    }

    /**
     * @param object $object
     * @return string
     */
    private function getObjectHash($object) {
        return spl_object_hash($object);
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
    private $modelBeforeId;
    /**
     * @param Varien_Event_Observer $observer
     */
    public function modelBefore(Varien_Event_Observer $observer) {
        /**
         * @var $savedObject Mage_Core_Model_Abstract
         */
        $savedObject = $observer->getObject();
        $this->storeCurrentHash($savedObject);
        $this->storeBeforeId($savedObject->getId());
    }

    /**
     * @var array
     */
    private $beforeIds = array();
    /**
     * @param $id
     */
    private function storeBeforeId($id) {
        $this->beforeIds[$this->currentHash] = $id;
    }

    /**
     * @return int
     */
    protected function getAction() {
        if (isset($this->beforeIds[$this->currentHash]) AND $this->beforeIds[$this->currentHash]) {
            return Firegento_AdminLogger_Helper_Data::ACTION_UPDATE;
        } else {
            return Firegento_AdminLogger_Helper_Data::ACTION_INSERT;
        }
    }

}