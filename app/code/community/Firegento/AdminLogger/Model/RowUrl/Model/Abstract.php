<?php
abstract class Firegento_AdminLogger_Model_RowUrl_Model_Abstract {
    /**
     * @return string
     */
    abstract protected function getClassName();

    /**
     * @return string
     */
    abstract protected function getRoutePath();

    /**
     * @param Mage_Core_Model_Abstract $model
     * @return array
     */
    abstract protected function getRouteParams(Mage_Core_Model_Abstract $model);
    /**
     * sets the row url in the transport object for a cms_page model
     *
     * @param Varien_Event_Observer $observer
     */
    public function setRowUrl(Varien_Event_Observer $observer) {
        /**
         * @var $history Firegento_AdminLogger_Model_History
         */
        $history = $observer->getHistory();
        $rowUrl = $this->getRowUrl(
            $history,
            $this->getClassName(),
            $this->getRoutePath(),
            $this->getRouteParams($history->getOriginalModel())
        );
        if ($rowUrl) {
            $observer->getTransport()->setRowUrl($rowUrl);
        }
   }

    /**
     * @param Firegento_AdminLogger_Model_History $history
     * @param string                              $className
     * @param string                              $routePath
     * @param array                               $routeParams
     * @return Mage_Adminhtml_Model_Url
     */
    protected function getRowUrl(Firegento_AdminLogger_Model_History $history, $className, $routePath, $routeParams) {
        /**
         * @var $history Firegento_AdminLogger_Model_History
         */
        if (!$history->isDelete()) {
            $model = $history->getOriginalModel();
            if (is_a($model, $className) AND $model->getId()) {
                return Mage::getModel('adminhtml/url')->getUrl(
                    $routePath,
                    $routeParams
                );
            }
        }

    }
}