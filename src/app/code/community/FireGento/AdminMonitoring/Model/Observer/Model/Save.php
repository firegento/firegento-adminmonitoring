<?php
class FireGento_AdminMonitoring_Model_Observer_Model_Save extends FireGento_AdminMonitoring_Model_Observer_Model_Abstract
{
    private $currentHash;

    /**
     * @param Varien_Event_Observer $observer
     */
    public function modelAfter(Varien_Event_Observer $observer)
    {
        $this->setCurrentHash($observer->getObject());
        parent::modelAfter($observer);
    }

    /**
     * @param Mage_Core_Model_Abstract $model
     */
    private function setCurrentHash(Mage_Core_Model_Abstract $model)
    {
        $this->currentHash = $this->getObjectHash($model);
    }

    /**
     * @param  object $object
     * @return string
     */
    private function getObjectHash($object)
    {
        return spl_object_hash($object);
    }

    /**
     * @return bool
     */
    protected function hasChanged()
    {
        return (!$this->isUpdate() OR parent::hasChanged());
    }

    /**
     * @return bool
     */
    private function isUpdate ()
    {
        return $this->getAction() == FireGento_AdminMonitoring_Helper_Data::ACTION_UPDATE;
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function modelBefore(Varien_Event_Observer $observer)
    {
        /**
         * @var $savedObject Mage_Core_Model_Abstract
         */
        $savedObject = $observer->getObject();
        $this->setCurrentHash($savedObject);
        $this->storeBeforeId($savedObject->getId());
    }

    /**
     * @var array
     */
    private $beforeIds = array();
    /**
     * @param $id
     */
    private function storeBeforeId($id)
    {
        $this->beforeIds[$this->currentHash] = $id;
    }

    /**
     * @return int
     */
    protected function getAction()
    {
        if (
            // for models which call model_save_before
            $this->hadIdAtBefore()
            OR
            // for models with origData but without model_save_before like Mage_CatalogInventory_Model_Stock_Item
            $this->hasOrigData()
         ) {
            return FireGento_AdminMonitoring_Helper_Data::ACTION_UPDATE;
        } else {
            return FireGento_AdminMonitoring_Helper_Data::ACTION_INSERT;
        }
    }

    /**
     * @return bool
     */
    private function hadIdAtBefore()
    {
        return (
            isset($this->beforeIds[$this->currentHash])
            AND $this->beforeIds[$this->currentHash]
        );
    }

    /**
     * @return bool
     */
    private function hasOrigData()
    {
        $data = $this->savedModel->getOrigData();
        // unset website_ids as this is even on new entities set for catalog_product models
        unset($data['website_ids']);
        return (bool) $data;
    }

}
