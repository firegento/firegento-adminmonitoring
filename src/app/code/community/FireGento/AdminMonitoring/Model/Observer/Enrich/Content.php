<?php

class FireGento_AdminMonitoring_Model_Observer_Enrich_Content {

    public function enrich(Varien_Event_Observer $observer)
    {
        $model = $observer->getObject();

        if ($model instanceof Mage_Admin_Model_Roles) {
            $model->setResourcesList2D($model->getResourcesList2D());
        }

        if ($model instanceof Mage_Admin_Model_User) {
            $model->setRoles($model->getRoles());
        }
    }

}