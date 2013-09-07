<?php
class Firegento_AdminLogger_Model_History extends Mage_Core_Model_Abstract
{
    protected function _construct() {
        $this->_init('firegento_adminlogger/history');
    }

    /**
     * @return Mage_Core_Model_Abstract
     */
    public function getOriginalModel() {
        $objectType = $this->getObjectType();
        /* @var Mage_Core_Model_Abstract $model */
        $model = new $objectType;
        $model->load($this->getObjectId());
        return $model;
    }

    /**
     * @return stdObject
     */
    public function getDecodedContentDiff() {
        return json_decode($this->getContentDiff(), true);
    }

    /**
     * @return bool
     */
    public function isUpdate() {
        return ($this->getAction() == Firegento_AdminLogger_Helper_Data::ACTION_UPDATE);
    }

    /**
     * @return bool
     */
    public function isDelete() {
        return ($this->getAction() == Firegento_AdminLogger_Helper_Data::ACTION_DELETE);
    }

}