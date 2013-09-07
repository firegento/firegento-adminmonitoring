<?php
class Firegento_AdminLogger_Model_Observer {
    /**
     * @param Varien_Event_Observer $observer
     */
    public function modelSaveAfter(Varien_Event_Observer $observer) {
        /**
         * @var $savedObject Mage_Core_Model_Abstract
         */
        $savedObject = $observer->getObject();
        if (!($savedObject instanceof Firegento_Adminlogger_Model_History)) {
            $this->createHistoryForSavedModel($savedObject);
        }
    }

    /**
     * @return int|NULL
     */
    private function getUserId() {
        /**
         * @var $session Mage_Admin_Model_Session
         */
        $session = Mage::getSingleton('admin/session');
        if ($session->getUser()) {
            $userId = $session
                ->getUser()
                ->getUserId();
        } else {
            $userId = NULL;
        }
        return $userId;
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
     * @return mixed
     */
    private function getModelId(Mage_Core_Model_Abstract $savedModel) {
        return $savedModel->getId();
    }

    /**
     * @param Mage_Core_Model_Abstract $savedModel
     */
    private function createHistoryForSavedModel(Mage_Core_Model_Abstract $savedModel) {
        /**
         * @var $history Firegento_AdminLogger_Model_History
         */
        $history = Mage::getModel('firegento_adminlogger/history');
        $history->setData(
            array(
                 'entity_id'   => $this->getModelId($savedModel),
                 'entity_type' => $this->getModelType($savedModel),
                 'data'        => $this->getSerializedModelData($savedModel),
                 'user_agent'  => $this->getUserAgent(),
                 'ip'          => $this->getRemoteAddr(),
                 'user_id'     => $this->getUserId(),
            )
        );
        $history->save();
    }
}