<?php
class FireGento_AdminMonitoring_Model_History extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('firegento_adminmonitoring/history');
    }

    /**
     * @return Mage_Core_Model_Abstract
     */
    public function getOriginalModel()
    {
        $objectType = $this->getObjectType();
        /* @var Mage_Core_Model_Abstract $model */
        $model = new $objectType;
        $content = $this->getDecodedContent();
        if (isset($content['store_id'])) {
            $model->setStoreId($content['store_id']);
        }
        $model->load($this->getObjectId());
        return $model;
    }

    /**
     * @return array
     */
    public function getDecodedContentDiff()
    {
        return json_decode($this->getContentDiff(), true);
    }

    /**
     * @return array
     */
    private function getDecodedContent()
    {
        return json_decode($this->getContent(), true);
    }

    /**
     * @return bool
     */
    public function isUpdate()
    {
        return ($this->getAction() == FireGento_AdminMonitoring_Helper_Data::ACTION_UPDATE);
    }

    /**
     * @return bool
     */
    public function isDelete()
    {
        return ($this->getAction() == FireGento_AdminMonitoring_Helper_Data::ACTION_DELETE);
    }

}
