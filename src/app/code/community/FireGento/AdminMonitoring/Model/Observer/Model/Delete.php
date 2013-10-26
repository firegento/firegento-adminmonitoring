<?php
class FireGento_AdminMonitoring_Model_Observer_Model_Delete extends FireGento_AdminMonitoring_Model_Observer_Model_Abstract
{
    /**
     * @return int
     */
    protected function getAction()
    {
        return FireGento_AdminMonitoring_Helper_Data::ACTION_DELETE;
    }
}
