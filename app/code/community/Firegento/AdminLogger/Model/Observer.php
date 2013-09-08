<?php
class Firegento_AdminLogger_Model_Observer {
    const ACTION_SAVE = 'save';
    const ACTION_DELETE = 'delete';
    const XML_PATH_ADMINLOGGER_CLEAN_ENABLED = 'admin/firegento_adminlogger/enable_cleaning';

    /**
     * @var Firegento_AdminLogger_Model_History_Diff
     */
    private $diffModel;

    /**
     * @var Firegento_AdminLogger_Model_History_Data
     */
    private $dataModel;

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
        Mage::dispatchEvent(
            'firegento_adminlogger_log',
            array(
                 'object_id'    => $this->dataModel->getObjectId(),
                 'object_type'  => $this->dataModel->getObjectType(),
                 'content'      => $this->dataModel->getSerializedContent(),
                 'content_diff' => $this->diffModel->getSerializedDiff(),
                 'action'       => $this->getAction($savedModel),
            )
        );
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    private function storeByObserver(Varien_Event_Observer $observer) {
        /**
         * @var $savedModel Mage_Core_Model_Abstract
         */
        $savedModel = $observer->getObject();
        if (
            !$this->isExcludedClass($savedModel)
        ) {
            $this->dataModel = Mage::getModel('firegento_adminlogger/history_data', $savedModel);
            $this->diffModel = Mage::getModel('firegento_adminlogger/history_diff', $this->dataModel);
            if (!$this->isUpdate($savedModel) OR $this->diffModel->hasChanged()) {
                $this->createHistoryForModelAction($savedModel);
            }
        }
    }

    /**
     * @param Mage_Core_Model_Abstract $savedModel
     * @return bool
     */
    private function isExcludedClass(Mage_Core_Model_Abstract $savedModel) {
        // skip logging for some classes
        $objectTypeExcludes = array_keys(Mage::getStoreConfig('firegento_adminlogger_config/exclude/object_types'));
        $objectTypeExcludesFiltered = array_filter(
            $objectTypeExcludes,
            function ($className) use($savedModel) {
                return is_a($savedModel, $className);
            }
        );
        return (count($objectTypeExcludesFiltered) > 0);
    }

    /**
     * @param Mage_Core_Model_Abstract $savedModel
     * @return bool
     */
    private function isUpdate (Mage_Core_Model_Abstract $savedModel) {
        return $this->getAction($savedModel) == Firegento_AdminLogger_Helper_Data::ACTION_UPDATE;
    }

    /**
     * Cleaning Database Entries
     *
     * @param Mage_Cron_Model_Schedule $schedule
     */
    public function scheduledCleanAdminLogger (Mage_Cron_Model_Schedule $schedule) {

        if (!Mage::getStoreConfigFlag(self::XML_PATH_ADMINLOGGER_CLEAN_ENABLED)) {
            return $this;
        }

        try {
            Mage::getModel('firegento_adminlogger/clean')->clean();
        }
        catch (Exception $e) {
            Mage::logException($e);
        }
    }
}