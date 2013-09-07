<?php

class Firegento_AdminLogger_Adminhtml_HistoryController extends Mage_Adminhtml_Controller_Action {

    /**
     * @return Firegento_AdminLogger_Adminhtml_HistoryController
     */
    protected function _initAction() {
        $this->loadLayout();
        $this->_setActiveMenu('firegento_adminlogger/history');
        $this->_addBreadcrumb(Mage::helper('firegento_adminlogger')->__('AdminLogger'), Mage::helper('firegento_adminlogger')->__('History'));
        return $this;
    }

    public function indexAction() {
        $this->_initAction();
        $this->renderLayout();
    }
}