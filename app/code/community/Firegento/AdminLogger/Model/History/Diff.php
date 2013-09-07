<?php
class Firegento_AdminLogger_Model_History_Diff {
    /**
     * @var Firegento_AdminLogger_Model_History_Data
     */
    private $dataModel;

    /**
     * @param Firegento_AdminLogger_Model_History_Data $dataModel
     */
    public function __construct(Firegento_AdminLogger_Model_History_Data $dataModel) {
        $this->dataModel = $dataModel;
    }

    /**
     * @return bool
     */
    public function hasChanged() {
        $history = $this->getPreviousHistory();

        if ($history AND $history->getContent() == $this->dataModel->getSerializedContent()) {
            return false;
        }
    }

    /**
     * @var Firegento_AdminLogger_Model_History
     */
    private $previousHistory;
    /**
     * @param Mage_Core_Model_Abstract $savedModel
     * @return bool|Varien_Object
     */
    private function getPreviousHistory() {
        if (!isset($this->previousHistory)) {
            /**
             * @var $collection Firegento_AdminLogger_Model_Resource_History_Collection
             */
            $collection = Mage::getModel('firegento_adminlogger/history')
                ->getCollection();
            $collection->addFieldToFilter('object_type', $this->dataModel->getObjectType());
            $collection->addFieldToFilter('object_id', $this->dataModel->getObjectId());
            $collection->addOrder('created_at', 'DESC');
            $collection->setPageSize(1);
            $this->previousHistory = $collection->fetchItem();
        }
        return $this->previousHistory;
    }

    /**
     * @return string
     */
    public function getSerializedDiff() {
        $history = $this->getPreviousHistory();

        if ($history) {
            return json_encode(
                array_diff(
                    json_decode($history->getContent()),
                    $this->dataModel->getContent()
                )
            );
        }
        return '';
    }

}