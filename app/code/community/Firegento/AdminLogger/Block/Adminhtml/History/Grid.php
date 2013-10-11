<?php

class Firegento_AdminLogger_Block_Adminhtml_History_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();

        $this->setId('firegento_adminlogger_grid');

        $this->setDefaultSort('history_id');
        $this->setDefaultDir('desc');

        $this->setSaveParametersInSession(true);
    }

    /**
     * @param mixed $value
     * @param string $key
     * @return string
     */
    private function formatCellContent ($key, $value) {
        if (is_array($value)) {
            $value = print_r($value, true);
        }
        return  $this->entities($key . ': ' . $value) . '<br />';
    }

    /**
     * @param $string
     * @return string
     */
    private function entities($string) {
        return htmlspecialchars($string, ENT_QUOTES|ENT_COMPAT, 'UTF-8');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('firegento_adminlogger/history')->getCollection();
        $collection->setOrder('history_id', 'DESC');
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    /**
     * @return Firegento_AdminLogger_Block_Adminhtml_History_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('history_id', array(
            'header' => Mage::helper('firegento_adminlogger')->__('ID'),
            'align' => 'right',
            'index' => 'history_id',
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('firegento_adminlogger')->__('Date/Time'),
            'index' => 'created_at',
            'type' => 'datetime',
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('firegento_adminlogger')->__('Action'),
            'index' => 'action',
            'type' => 'options',
            'options' => array(
                Firegento_AdminLogger_Helper_Data::ACTION_UPDATE => $this->__('Update'),
                Firegento_AdminLogger_Helper_Data::ACTION_INSERT => $this->__('Insert'),
                Firegento_AdminLogger_Helper_Data::ACTION_DELETE => $this->__('Delete'),
            )
        ));

        $this->addColumn('object_type', array(
            'header' => Mage::helper('firegento_adminlogger')->__('Object Type'),
            'index' => 'object_type',
        ));

        $this->addColumn('object_id', array(
            'header' => Mage::helper('firegento_adminlogger')->__('Object ID'),
            'index' => 'object_id',
            'type' => 'number',
        ));

        $this->addColumn('content', array(
            'header' => Mage::helper('firegento_adminlogger')->__('Content New'),
            'index' => 'content',
            'frame_callback' => array($this, 'showNewContent'),
        ));

        $this->addColumn('content_diff', array(
            'header' => Mage::helper('firegento_adminlogger')->__('Diff to getOrigData()'),
            'index' => 'content_diff',
            'frame_callback' => array($this, 'showOldContent'),
        ));

        $optionArray = array();
        $model = Mage::getModel('admin/user');
        $adminUsers = $model->getCollection();
        foreach($adminUsers as $adminUser){
            $optionArray[$adminUser->getId()] = $this->entities($adminUser->getUsername());
        }

        $this->addColumn('user_id', array(
            'header' => Mage::helper('firegento_adminlogger')->__('User'),
            'index' => 'user_id',
            'type' => 'options',
            'options' => $optionArray,
        ));

        $this->addColumn('user_name', array(
            'header' => Mage::helper('firegento_adminlogger')->__('User name logged'),
            'index' => 'user_name',
        ));

        $this->addColumn('ip', array(
            'header' => Mage::helper('firegento_adminlogger')->__('IP'),
            'index' => 'ip',
        ));

        $this->addColumn('user_agent', array(
            'header' => Mage::helper('firegento_adminlogger')->__('User Agent'),
            'index' => 'user_agent',
        ));

        $this->addColumn('revert', array(
            'header'    => Mage::helper('customer')->__('Revert'),
            'width'     => 10,
            'sortable'  => false,
            'filter'    => false,
            'renderer'  => 'firegento_adminlogger/adminhtml_history_grid_revert',
        ));

        parent::_prepareColumns();
        return $this;
    }

    /**
     * @param $row
     * @return bool|string
     */
    public function getRowUrl($row)
    {
        $transport = new Varien_Object();
        Mage::dispatchEvent('firegento_adminlogger_rowurl', array('history' => $row, 'transport' => $transport));
        return $transport->getRowUrl();
    }

    /**
     * @param string $content
     * @return mixed
     */
    private function decodeContent($content) {
        $content = html_entity_decode($content);
        return json_decode($content, true);
    }

    /**
     * @param string $newContent
     * @param Firegento_AdminLogger_Model_History $row
     * @return string
     */
    public function showNewContent($newContent, Firegento_AdminLogger_Model_History $row) {
        $cell = '';

        if ($row->isDelete()) {
            $cell = '';
        } else {
            $oldContent = $row->getContentDiff();
            $oldContent = $this->decodeContent($oldContent);

            $newContent = $this->decodeContent($newContent);

            if (is_array($oldContent) && is_array($newContent)) {
                if (count($oldContent) > 0) {
                    $showContent = $oldContent;
                } else {
                    $showContent = $newContent;
                }
                foreach ($showContent as $key => $value ) {
                    if (array_key_exists($key, $newContent)) {
                        $attributeName = Mage::helper('firegento_adminlogger')->getAttributeNameByTypeAndCode($row->getObjectType(), $key);
                        $cell .= $this->formatCellContent($attributeName, $newContent[$key]);
                    }
                }
            }
        }
        return $this->wrapColor($cell, '#00ff00');
    }


    /**
     * @param string $oldContent
     * @param Firegento_AdminLogger_Model_History $row
     * @return string
     */
    public function showOldContent($oldContent, Firegento_AdminLogger_Model_History $row) {
        $cell = '';
        $oldContent = $this->decodeContent($oldContent);

        if (is_array($oldContent)) {
           if (count($oldContent) > 0) {
               foreach ($oldContent as $key => $value ) {
                   $attributeName = Mage::helper('firegento_adminlogger')->getAttributeNameByTypeAndCode($row->getObjectType(), $key);
                   $cell .= $this->formatCellContent($attributeName, $value);
               }
           } else {
               return $this->__('not available');
           }
        }
        return $this->wrapColor($cell, '#ff0000');
    }

    /**
     * @param string $string
     * @param string $color
     * @return string
     */
    private function wrapColor($string, $color) {
        return '<div style="font-weight: bold; color: ' . $color . '; overflow: auto; max-height: 100px; max-width: 400px;">' . $string . '</div>';
    }
}