<?php
class FireGento_AdminMonitoring_Model_RowUrl_Model_Product extends FireGento_AdminMonitoring_Model_RowUrl_Model_Abstract
{
    /**
     * @return string
     */
    protected function getClassName()
    {
        return 'Mage_Catalog_Model_Product';
    }

    /**
     * @return string
     */
    protected function getRoutePath()
    {
        return 'adminhtml/catalog_product/edit';
    }

    /**
     * @param  Mage_Core_Model_Abstract $model
     * @return array
     */
    protected function getRouteParams(Mage_Core_Model_Abstract $model)
    {
        return array(
            'id'    => $model->getId(),
            'store' => $model->getStoreId(),
        );
    }
}
