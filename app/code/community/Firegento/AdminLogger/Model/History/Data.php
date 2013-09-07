<?php
class Firegento_AdminLogger_Model_History_Data {
    /**
     * @var Mage_Core_Model_Abstract
     */
    private $savedModel;

    /**
     * @param Mage_Core_Model_Abstract $savedModel
     */
    public function __construct(Mage_Core_Model_Abstract $savedModel) {
        $this->savedModel = $savedModel;
    }

    /**
     * @return string
     */
    public function getSerializedContent() {
        return json_encode($this->getContent());
    }

    /**
     * @return array
     */
    public function getContent() {
        $data = $this->savedModel->getData();
        unset($data['updated_at']);
        return $data;
    }

    /**
     * @return string
     */
    public function getObjectType() {
        return get_class($this->savedModel);
    }

    /**
     * @return int
     */
    public function getObjectId() {
        return $this->savedModel->getId();
    }
}