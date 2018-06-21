<?php

class FireGento_AdminMonitoring_Model_Observer_Enrich_OrigContent {

    public function enrich(Varien_Event_Observer $observer)
    {
        $data = $observer->getDataObject();
        $class = $observer->getModelObject();

        if ($class instanceof Mage_Admin_Model_Roles) {
            $data->setResourcesList2D($class->getResourcesList2D());
        }

        if ($class instanceof Mage_Admin_Model_User) {
            $data->setRoles($class->getRoles());
        }
    }

}