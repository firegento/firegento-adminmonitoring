<?php
class Firegento_AdminLogger_Block_Adminhtml_History_Grid_Revert extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
    /**
     * @param Varien_Object $row
     * @return string
     * @throws Exception
     */
    public function render(Varien_Object $row) {
        if ($row instanceof Firegento_AdminLogger_Model_History) {
            if ($row->isUpdate() AND $row->getDecodedContentDiff()) {
                return '<a href="' . $this->getUrl('*/*/revert', array('id' => $row->getId())) . '">Revert</a>';
            }
        } else {
            throw new Exception('block is only compatible to Firegento_AdminLogger_Model_History');
        }
    }
}