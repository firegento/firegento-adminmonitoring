<?php
class FireGento_AdminMonitoring_Model_History_Diff
{
    /**
     * @var FireGento_AdminMonitoring_Model_History_Data
     */
    private $dataModel;

    /**
     * @param FireGento_AdminMonitoring_Model_History_Data $dataModel
     */
    public function __construct(FireGento_AdminMonitoring_Model_History_Data $dataModel)
    {
        $this->dataModel = $dataModel;
    }

    /**
     * @return bool
     */
    public function hasChanged()
    {
        return ($this->dataModel->getContent() != $this->dataModel->getOrigContent());
    }

    /**
     * @return array
     */
    private function getObjectDiff ()
    {
        $dataOld = $this->dataModel->getOrigContent();
        if (is_array($dataOld)) {
            $dataNew = $this->dataModel->getContent();
            $dataDiff = array();
            foreach ($dataOld as $key => $oldValue) {
                // compare objects serialized
                if (
                    isset($dataNew[$key])
                    AND (json_encode($oldValue) != json_encode($dataNew[$key]))
                ) {
                    $dataDiff[$key] = $oldValue;
                }
            }
            return $dataDiff;
        } else {
            return array();
        }
    }

    /**
     * @return string
     */
    public function getSerializedDiff()
    {
        $dataDiff = $this->getObjectDiff();
        return json_encode($dataDiff);
    }

}
