<?php

class Firegento_AdminLogger_Block_Adminhtml_History extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'firegento_adminlogger';
		$this->_controller = 'adminhtml_history';
		
		$this->_headerText = Mage::helper('firegento_adminlogger')->__('History');
		#$this->_addButtonLabel = Mage::helper('firegento_adminlogger')->__('Log hinzufügen');

		parent::__construct();
        $this->removeButton('add');
	}
}