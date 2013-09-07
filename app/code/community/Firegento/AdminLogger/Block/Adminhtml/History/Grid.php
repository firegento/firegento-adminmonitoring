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
            'header' => Mage::helper('firegento_adminlogger')->__('Content Old'),
            'index' => 'content_diff',
            'frame_callback' => array($this, 'showOldContent'),
        ));

        $optionArray = array();
        $model = Mage::getModel('admin/user');
        $adminUsers = $model->getCollection();
        foreach($adminUsers as $adminUser){
            $optionArray[$adminUser->getId()] = $adminUser->getUsername();
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
        return false;
    }


    public function showNewContent($newContent, $row)
    {
        $cell = '';

        $oldContent = $row->getData('content_diff');
        $oldContent = html_entity_decode($oldContent);
        $oldContent = json_decode($oldContent, true);

        $newContent = html_entity_decode($newContent);
        $newContent = json_decode($newContent, true);

        if (is_array($oldContent) && is_array($newContent)) {
            foreach ($oldContent as $key => $value ) {

                if (array_key_exists($key, $newContent)) {
                    if (is_array($newContent[$key])) {
                        $newContent[$key] = print_r($newContent[$key], true);
                    }
                    $cell .= $key.': ' . $newContent[$key] . '<br />';
                }
            }
        }

        return $cell;
    }


    public function showOldContent($oldContent, $row)
    {
        $cell = '';
        $oldContent = html_entity_decode($oldContent);
        $oldContent = json_decode($oldContent, true);

        if (is_array($oldContent)) {
           foreach ($oldContent as $key => $value ) {
               if (is_array($value)) {
                   $value = print_r($value, true);
               }
               $cell .= $key.': ' . $value . '<br />';
           }
        }
        return $cell;
    }
}