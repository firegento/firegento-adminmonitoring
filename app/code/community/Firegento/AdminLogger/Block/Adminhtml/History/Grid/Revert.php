<?php
class Firegento_AdminLogger_Block_Adminhtml_History_Grid_Revert extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
    public function render(Varien_Object $row)
    {
        return '<a href="' . $this->getUrl('*/*/revert', array('id' => $row->getId())) . '">Revert</a>';
    }
}