<?php
class Firegento_AdminLogger_Model_Observer_Log {
    /**
     * @param Varien_Event_Observer $observer
     */
    public function log(Varien_Event_Observer $observer) {
        /**
         * @var $history Firegento_AdminLogger_Model_History
         */
        $history = Mage::getModel('firegento_adminlogger/history');
        $history->setData(
            array(
                 'object_id'    => $observer->getObjectId(),
                 'object_type'  => $observer->getObjectType(),
                 'content'      => $observer->getContent(),
                 'content_diff' => $observer->getContentDiff(),
                 'user_agent'   => $this->getUserAgent(),
                 'ip'           => $this->getRemoteAddr(),
                 'user_id'      => $this->getUserId(),
                 'user_name'    => $this->getUserName(),
                 'action'       => $observer->getAction(),
                 'created_at'   => now(),
            )
        );
        $history->save();
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
        return (isset($_SERVER['HTTP_USER_AGENT']) ? (string)$_SERVER['HTTP_USER_AGENT'] : '');
    }

    /**
     * @return MageTest_Core_Helper_Http
     */
    private function getRemoteAddr() {
        return Mage::helper('core/http')
            ->getRemoteAddr();
    }

}