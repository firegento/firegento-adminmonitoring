<?php
class Firegento_AdminLogger_Model_RowUrl_Page {
    /**
     * sets the row url in the transport object for a cms_page model
     *
     * @param Varien_Event_Observer $observer
     */
    public function setRowUrl(Varien_Event_Observer $observer) {
        $model = $observer->getHistory()->getOriginalModel();
        if ($model instanceof Mage_Cms_Model_Page) {
            $observer->getTransport()->setRowUrl(
                Mage::getModel('adminhtml/url')->getUrl(
                    'adminhtml/cms_page/edit',
                    array(
                        'page_id' => $model->getId(),
                    )
                )
            );
        }
    }
}