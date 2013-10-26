<?php
class FireGento_AdminMonitoring_Model_History_Data
{
    /**
     * @var Mage_Core_Model_Abstract
     */
    private $savedModel;

    /**
     * @param Mage_Core_Model_Abstract $savedModel
     */
    public function __construct(Mage_Core_Model_Abstract $savedModel)
    {
        $this->savedModel = $savedModel;
    }

    /**
     * @return string
     */
    public function getSerializedContent()
    {
        return json_encode($this->getContent());
    }

    /**
     * @return array
     */
    public function getContent()
    {
        // have to re-load the model as based on database datatypes the format of values changes
        $className = get_class($this->savedModel);
        $model = new $className;
        $model->setStoreId($this->savedModel->getStoreId());
        $model->load($this->savedModel->getId());
        return $this->filterObligatoryFields($model->getData());
   }

    /**
     * @param  array $data
     * @return array
     */
    protected function filterObligatoryFields($data)
    {
        $fields = array_keys(Mage::getStoreConfig('firegento_adminmonitoring_config/exclude/fields'));
        foreach ($fields as $field) {
            unset($data[$field]);
        }
        return $data;
    }

    /**
     * @return array
     */
    public function getOrigContent()
    {
        $data = $this->savedModel->getOrigData();
        return $this->filterObligatoryFields($data);
    }

    /**
     * @return string
     */
    public function getObjectType()
    {
        return get_class($this->savedModel);
    }

    /**
     * @return int
     */
    public function getObjectId()
    {
        return $this->savedModel->getId();
    }
}
