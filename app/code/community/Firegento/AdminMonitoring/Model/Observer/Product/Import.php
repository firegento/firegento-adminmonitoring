<?php
class Firegento_AdminMonitoring_Model_Observer_Product_Import
    extends Firegento_AdminMonitoring_Model_Observer_Log
{

    const XML_PATH_ADMINMONITORING_LOG_PRODUCT_IMPORT = 'admin/firegento_adminmonitoring/product_import_logging';

    public function catalogProductImportFinishBefore(Varien_Event_Observer $observer)
    {
        if (!Mage::getStoreConfig(self::XML_PATH_ADMINMONITORING_LOG_PRODUCT_IMPORT)) {
            return;
        }

        $productIds = $observer->getEvent()->getAdapter()->getAffectedEntityIds();

        /** @var Firegento_AdminMonitoring_Model_History $history */
        $history = Mage::getModel('firegento_adminmonitoring/history');

        $objectType = get_class(Mage::getModel('catalog/product'));
        $content = json_encode(array('updated_during_import' => ''));
        $userAgent = $this->getUserAgent();
        $ip = $this->getRemoteAddr();
        $userId = $this->getUserId();
        $userName = $this->getUserName();

        foreach ($productIds as $productId) {
            $history->setData(
                array(
                    'object_id'    => $productId,
                    'object_type'  => $objectType,
                    'content'      => $content,
                    'content_diff' => '{}',
                    'user_agent'   => $userAgent,
                    'ip'           => $ip,
                    'user_id'      => $userId,
                    'user_name'    => $userName,
                    'action'       => Firegento_AdminMonitoring_Helper_Data::ACTION_UPDATE,
                    'created_at'   => now(),
                )
            );
            $history->save();
        }
    }
}