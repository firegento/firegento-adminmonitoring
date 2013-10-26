<?php

class Firegento_AdminMonitoring_Adminhtml_HistoryController extends Mage_Adminhtml_Controller_Action {

    /**
     * @return Firegento_AdminMonitoring_Adminhtml_HistoryController
     */
    protected function _initAction() {
        $this->loadLayout();
        $this->_setActiveMenu('firegento_adminmonitoring/history');
        $this->_addBreadcrumb(Mage::helper('firegento_adminmonitoring')->__('Admin Monitoring'), Mage::helper('firegento_adminmonitoring')->__('History'));
        return $this;
    }

    public function indexAction() {
        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * reverts a history entry
     */
    public function revertAction() {
        $history = Mage::getModel('firegento_adminmonitoring/history')->load($this->getRequest()->getParam('id'));
        $model = $history->getOriginalModel();
        $model->addData($history->getDecodedContentDiff());
        $model->save();
        Mage::getSingleton('core/session')->addSuccess(
            $this->__(
                'Revert of %1$s with id %2$d successful',
                $history->getObjectType(),
                $history->getObjectId()
            )
        );
        $this->_redirect('*/*/index');
    }


}