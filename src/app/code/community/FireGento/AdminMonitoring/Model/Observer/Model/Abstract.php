<?php
abstract class FireGento_AdminMonitoring_Model_Observer_Model_Abstract
{
    /**
     * @var Mage_Core_Model_Abstract
     */
    protected $savedModel;

    /**
     * @var FireGento_AdminMonitoring_Model_History_Diff
     */
    private $diffModel;

    /**
     * @var FireGento_AdminMonitoring_Model_History_Data
     */
    private $dataModel;

    /**
     * @return int
     */
    abstract protected function getAction();

    /**
     * @param Varien_Event_Observer $observer
     */
    public function modelAfter(Varien_Event_Observer $observer)
    {
        $this->storeByObserver($observer);
    }

    /**
     * @return bool
     */
    protected function hasChanged()
    {
        return $this->diffModel->hasChanged();
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    protected function storeByObserver(Varien_Event_Observer $observer)
    {
        /**
         * @var $savedModel Mage_Core_Model_Abstract
         */
        $savedModel = $observer->getObject();
        $this->savedModel = $savedModel;
        if (
            !$this->isExcludedClass($savedModel)
        ) {
            $this->dataModel = Mage::getModel('firegento_adminmonitoring/history_data', $savedModel);
            $this->diffModel = Mage::getModel('firegento_adminmonitoring/history_diff', $this->dataModel);
            if ($this->hasChanged()) {
                $this->createHistoryForModelAction();
            }
        }
    }

    /**
     */
    private function createHistoryForModelAction()
    {
        Mage::dispatchEvent(
            'firegento_adminmonitoring_log',
            array(
                 'object_id'    => $this->dataModel->getObjectId(),
                 'object_type'  => $this->dataModel->getObjectType(),
                 'content'      => $this->dataModel->getSerializedContent(),
                 'content_diff' => $this->diffModel->getSerializedDiff(),
                 'action'       => $this->getAction(),
            )
        );
    }

    /**
     * @return bool
     */
    private function isExcludedClass()
    {
        $savedModel = $this->savedModel;
        // skip logging for some classes
        $objectTypeExcludes = array_keys(Mage::getStoreConfig('firegento_adminmonitoring_config/exclude/object_types'));
        $objectTypeExcludesFiltered = array_filter(
            $objectTypeExcludes,
            function ($className) use ($savedModel) {
                return is_a($savedModel, $className);
            }
        );
        return (count($objectTypeExcludesFiltered) > 0);
    }

}
