<?php
class Firegento_AdminLogger_Test_Model_Observer extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var Firegento_AdminLogger_Model_Observer
     */
    protected $_object;

    protected function setUp()
    {
        parent::setUp();
        $this->_object = Mage::getModel('firegento_adminlogger/observer');
    }

    /**
     * Create event to pass into observer method
     *
     * @param array $data
     */
    protected function _createObserver(array $data)
    {
        $event = new Varien_Event($data);
        $data['event'] = $event;
        $observer = new Varien_Event_Observer();
        return $observer->setData($data);
    }

    /**
     * if Firegento_AdminLogger_Model_History is saved, don't do anything inside the observer
     */
    public function testNoHistorySaves()
    {
        $object = new Firegento_AdminLogger_Model_History();
        $data = array('object' => $object);
        $observer = $this->_createObserver($data);

        $mock = $this->getModelMock('firegento_adminlogger/history');
        $mock->expects($this->never())->method('save');
        $this->replaceByMock('model', 'firegento_adminlogger/history', $mock);

        Mage::getModel('firegento_adminlogger/observer')->modelSaveAfter($observer);
    }
}