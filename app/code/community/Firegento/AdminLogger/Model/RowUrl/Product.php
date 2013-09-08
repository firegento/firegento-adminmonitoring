<?php
class Firegento_AdminLogger_Model_RowUrl_Product {
    /**
     * sets the row url in the transport object for a catalog_product model
     *
     * @param Varien_Event_Observer $observer
     */
    public function setRowUrl(Varien_Event_Observer $observer) {
        /**
         * @var $history Firegento_AdminLogger_Model_History
         */
        $history = $observer->getHistory();
        if (!$history->isDelete()) {
            $model = $history->getOriginalModel();
            if ($model instanceof Mage_Catalog_Model_Product) {
                $observer->getTransport()->setRowUrl(
                    Mage::getModel('adminhtml/url')->getUrl(
                        'adminhtml/catalog_product/edit',
                        array(
                            'id'    => $model->getId(),
                            'store' => $model->getStoreId(),
                        )
                    )
                );
            }
        }
    }
}