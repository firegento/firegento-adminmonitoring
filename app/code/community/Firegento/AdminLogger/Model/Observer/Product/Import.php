<?php
class Firegento_AdminLogger_Model_Observer_Product_Import
    extends Firegento_AdminLogger_Model_Observer_Log
{

    public function catalogProductImportFinishBefore(Varien_Event_Observer $observer)
    {
        $productIds = $observer->getEvent()->getAdapter()->getAffectedEntityIds();

        /** @var Firegento_AdminLogger_Model_History $history */
        $history = Mage::getModel('firegento_adminlogger/history');

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
                    'action'       => Firegento_AdminLogger_Helper_Data::ACTION_UPDATE,
                    'created_at'   => now(),
                )
            );
            $history->save();
        }
    }
}