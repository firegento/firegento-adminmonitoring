<?php

class FireGento_AdminMonitoring_Block_Adminhtml_History extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'firegento_adminmonitoring';
        $this->_controller = 'adminhtml_history';

        $this->_headerText = Mage::helper('firegento_adminmonitoring')->__('History');
        #$this->_addButtonLabel = Mage::helper('firegento_adminmonitoring')->__('Log hinzufügen');

        parent::__construct();
        $this->removeButton('add');
    }
}
