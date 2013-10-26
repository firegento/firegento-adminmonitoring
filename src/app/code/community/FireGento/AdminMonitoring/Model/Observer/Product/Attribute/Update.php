<?php
class FireGento_AdminMonitoring_Model_Observer_Product_Attribute_Update
    extends FireGento_AdminMonitoring_Model_Observer_Log
{
    const XML_PATH_ADMINMONITORING_LOG_PRODUCT_MASS_UPDATE = 'admin/firegento_adminmonitoring/product_mass_update_logging';

    public function catalogProductAttributeUpdateBefore(Varien_Event_Observer $observer)
    {
        if (!Mage::getStoreConfig(self::XML_PATH_ADMINMONITORING_LOG_PRODUCT_MASS_UPDATE)) {
            return;
        }

        /** @var FireGento_AdminMonitoring_Model_History $history */
        $history = Mage::getModel('firegento_adminmonitoring/history');

        $objectType = get_class(Mage::getModel('catalog/product'));
        $content = json_encode($observer->getEvent()->getAttributesData());
        $userAgent = $this->getUserAgent();
        $ip = $this->getRemoteAddr();
        $userId = $this->getUserId();
        $userName = $this->getUserName();

        foreach ($observer->getEvent()->getProductIds() as $productId) {
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
                'action'       => FireGento_AdminMonitoring_Helper_Data::ACTION_UPDATE,
                'created_at'   => now(),
                )
            );
            $history->save();
            $history->clearInstance();
        }
    }
}
