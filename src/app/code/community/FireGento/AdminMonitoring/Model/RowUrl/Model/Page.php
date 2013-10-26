<?php
class FireGento_AdminMonitoring_Model_RowUrl_Model_Page extends FireGento_AdminMonitoring_Model_RowUrl_Model_Abstract
{
    /**
     * @return string
     */
    protected function getClassName()
    {
        return 'Mage_Cms_Model_Page';
    }

    /**
     * @return string
     */
    protected function getRoutePath()
    {
        return 'adminhtml/cms_page/edit';
    }

    /**
     * @param  Mage_Core_Model_Abstract $model
     * @return array
     */
    protected function getRouteParams(Mage_Core_Model_Abstract $model)
    {
        return array(
            'page_id' => $model->getId()
        );
    }
}
