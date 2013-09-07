<?php
class Firegento_AdminLogger_Model_Observer {
    const ACTION_SAVE = 'save';
    const ACTION_DELETE = 'delete';
    /**
     * @var string is either self::ACTION_SAVE or self::ACTION_DELETE;
     */
    private $modelAction = '';
    /**
     * @param Varien_Event_Observer $observer
     */
    public function modelSaveAfter(Varien_Event_Observer $observer) {
        $this->modelAction = self::ACTION_SAVE;
        $this->storeByObserver($observer);
    }

    private $modelSaveBeforeIds = array();
    /**
     * @param Varien_Event_Observer $observer
     */
    public function modelSaveBefore(Varien_Event_Observer $observer) {
        /**
         * @var $savedObject Mage_Core_Model_Abstract
         */
        $savedObject = $observer->getObject();
        $this->modelSaveBeforeIds[$this->getObjectHash($savedObject)] = $savedObject->getId();
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function modelDeleteAfter(Varien_Event_Observer $observer) {
        $this->modelAction = self::ACTION_DELETE;
        $this->storeByObserver($observer);
    }

    /**
     * @param object $savedObject
     * @return string
     */
    protected function getObjectHash ($savedObject) {
        return spl_object_hash($savedObject);
    }

    /**
     * @return int
     */
    private function getUserId() {
        if ($this->getUser()) {
            $userId = $this->getUser()
                ->getUserId();
        } else {
            $userId = 0;
        }
        return $userId;
    }

    /**
     * @return string
     */
    private function getUserName() {
        if ($this->getUser()) {
            $userName = $this->getUser()
                ->getUsername();
        } else {
            $userName = '';
        }
        return $userName;
    }

    /**
     * @return Mage_Admin_Model_User|NULL
     */
    private function getUser() {
        /**
         * @var $session Mage_Admin_Model_Session
         */
        $session = Mage::getSingleton('admin/session');
        return $session->getUser();
    }

    /**
     * @return string
     */
    private function getUserAgent() {
        return (string)$_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * @return MageTest_Core_Helper_Http
     */
    private function getRemoteAddr() {
        return Mage::helper('core/http')
            ->getRemoteAddr();
    }

    /**
     * @param Mage_Core_Model_Abstract $savedModel
     * @return string
     */
    private function getModelType(Mage_Core_Model_Abstract $savedModel) {
        return get_class($savedModel);
    }

    /**
     * @param Mage_Core_Model_Abstract $savedModel
     * @return string
     */
    private function getSerializedModelData(Mage_Core_Model_Abstract $savedModel) {
        return json_encode($savedModel->getData());
    }

    /**
     * @param Mage_Core_Model_Abstract $savedModel
     * @return int
     */
    private function getModelId(Mage_Core_Model_Abstract $savedModel) {
        return $savedModel->getId();
    }

    /**
     * @param Mage_Core_Model_Abstract $savedModel
     * @return int
     */
    private function getAction(Mage_Core_Model_Abstract $savedModel) {
        if ($this->modelAction == self::ACTION_DELETE) {
            return Firegento_AdminLogger_Helper_Data::ACTION_DELETE;
        }
        if (
            isset($this->modelSaveBeforeIds[$this->getObjectHash($savedModel)])
            AND $this->modelSaveBeforeIds[$this->getObjectHash($savedModel)]
        ) {
            return Firegento_AdminLogger_Helper_Data::ACTION_UPDATE;
        } else {
            return Firegento_AdminLogger_Helper_Data::ACTION_INSERT;
        }
    }

    /**
     * @param Mage_Core_Model_Abstract $savedModel
     */
    private function createHistoryForModelAction(Mage_Core_Model_Abstract $savedModel) {
        $this->getUser();
        /**
         * @var $history Firegento_AdminLogger_Model_History
         */
        $history = Mage::getModel('firegento_adminlogger/history');
        $history->setData(
            array(
                 'object_id'   => $this->getModelId($savedModel),
                 'object_type' => $this->getModelType($savedModel),
                 'data'        => $this->getSerializedModelData($savedModel),
                 'user_agent'  => $this->getUserAgent(),
                 'ip'          => $this->getRemoteAddr(),
                 'user_id'     => $this->getUserId(),
                 'user_name'   => $this->getUserName(),
                 'action'      => $this->getAction($savedModel),
                 'created_at'  => time(),
            )
        );
        $history->save();
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    private function storeByObserver(Varien_Event_Observer $observer) {
        /**
         * @var $savedObject Mage_Core_Model_Abstract
         */
        $savedObject = $observer->getObject();
        // skip logging for some classes
        $objectTypeExcludes = Mage::getStoreConfig('firegento_adminlogger_config/exclude/object_types');
        if (!(isset($objectTypeExcludes[get_class($savedObject)]))) {
            $this->createHistoryForModelAction($savedObject);
        }
    }
}