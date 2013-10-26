<?php
/**
 * This file is part of a FireGento e.V. module.
 *
 * This FireGento e.V. module is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License version 3 as
 * published by the Free Software Foundation.
 *
 * This script is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * PHP version 5
 *
 * @category  FireGento
 * @package   FireGento_AdminMonitoring
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2013 FireGento Team (http://www.firegento.com)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 */
/**
 * Displays the logging history grid
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Block_Adminhtml_History_Grid
    extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Grid constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('firegento_adminmonitoring_grid');
        $this->setDefaultSort('history_id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Retrieve helper class
     *
     * @return FireGento_AdminMonitoring_Helper_Data Helper Instance
     */
    public function getMonitoringHelper()
    {
        return Mage::helper('firegento_adminmonitoring');
    }

    /**
     * Prepare the grid collection
     *
     * @return FireGento_AdminMonitoring_Block_Adminhtml_History_Grid Self.
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('firegento_adminmonitoring/history')->getCollection();
        $collection->setOrder('history_id', 'DESC');
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare the grid columns
     *
     * @return FireGento_AdminMonitoring_Block_Adminhtml_History_Grid Self.
     */
    protected function _prepareColumns()
    {
        $this->addColumn('history_id', array(
            'header' => $this->getMonitoringHelper()->__('ID'),
            'align' => 'right',
            'index' => 'history_id',
        ));

        $this->addColumn('created_at', array(
            'header' => $this->getMonitoringHelper()->__('Date/Time'),
            'index' => 'created_at',
            'type' => 'datetime',
        ));

        $this->addColumn('action', array(
            'header' => $this->getMonitoringHelper()->__('Action'),
            'index' => 'action',
            'type' => 'options',
            'options' => array(
                FireGento_AdminMonitoring_Helper_Data::ACTION_UPDATE => $this->__('Update'),
                FireGento_AdminMonitoring_Helper_Data::ACTION_INSERT => $this->__('Insert'),
                FireGento_AdminMonitoring_Helper_Data::ACTION_DELETE => $this->__('Delete'),
            )
        ));

        $this->addColumn('object_type', array(
            'header' => $this->getMonitoringHelper()->__('Object Type'),
            'index' => 'object_type',
        ));

        $this->addColumn('object_id', array(
            'header' => $this->getMonitoringHelper()->__('Object ID'),
            'index' => 'object_id',
            'type' => 'number',
        ));

        $this->addColumn('content', array(
            'header' => $this->getMonitoringHelper()->__('Content New'),
            'index' => 'content',
            'frame_callback' => array($this, 'showNewContent'),
        ));

        $this->addColumn('content_diff', array(
            'header' => $this->getMonitoringHelper()->__('Diff to getOrigData()'),
            'index' => 'content_diff',
            'frame_callback' => array($this, 'showOldContent'),
        ));

        /* @var $adminUsers Mage_Admin_Model_Resource_User_Collection */
        $adminUsers = Mage::getResourceModel('admin/user_collection');
        $optionArray = array();
        foreach ($adminUsers as $adminUser) {
            $optionArray[$adminUser->getId()] = $this->entities($adminUser->getUsername());
        }

        $this->addColumn('user_id', array(
            'header' => $this->getMonitoringHelper()->__('User'),
            'index' => 'user_id',
            'type' => 'options',
            'options' => $optionArray,
        ));

        $this->addColumn('user_name', array(
            'header' => $this->getMonitoringHelper()->__('User name logged'),
            'index' => 'user_name',
        ));

        $this->addColumn('ip', array(
            'header' => $this->getMonitoringHelper()->__('IP'),
            'index' => 'ip',
        ));

        $this->addColumn('user_agent', array(
            'header' => $this->getMonitoringHelper()->__('User Agent'),
            'index' => 'user_agent',
        ));

        $this->addColumn('revert', array(
            'header'    => Mage::helper('customer')->__('Revert'),
            'width'     => 10,
            'sortable'  => false,
            'filter'    => false,
            'renderer'  => 'firegento_adminmonitoring/adminhtml_history_grid_revert',
        ));

        return parent::_prepareColumns();
    }

    /**
     * Retrieve the row url for the given history entry
     *
     * @param  FireGento_AdminMonitoring_Model_History $row History Model
     * @return bool|string
     */
    public function getRowUrl($row)
    {
        $transport = new Varien_Object();
        Mage::dispatchEvent('firegento_adminmonitoring_rowurl', array('history' => $row, 'transport' => $transport));
        return $transport->getRowUrl();
    }

    /**
     * Show the new content after the changes.
     *
     * @param  string                                  $newContent New Content
     * @param  FireGento_AdminMonitoring_Model_History $row        History Model
     * @return string
     */
    public function showNewContent($newContent, FireGento_AdminMonitoring_Model_History $row)
    {
        if ($row->isDelete()) {
            return '';
        }

        $cell = '';
        $oldContent = $row->getContentDiff();
        $oldContent = $this->decodeContent($oldContent);
        $newContent = $this->decodeContent($newContent);

        if (is_array($oldContent) && is_array($newContent)) {
            if (count($oldContent) > 0) {
                $showContent = $oldContent;
            } else {
                $showContent = $newContent;
            }
            foreach ($showContent as $key => $value) {
                if (array_key_exists($key, $newContent)) {
                    $attributeName = $this->getMonitoringHelper()
                        ->getAttributeNameByTypeAndCode($row->getObjectType(), $key);
                    $cell .= $this->formatCellContent($attributeName, $newContent[$key]);
                }
            }
        }

        return $this->wrapColor($cell, '#00ff00');
    }

    /**
     * Show the old content before the changes.
     *
     * @param  string                                  $oldContent Old Content
     * @param  FireGento_AdminMonitoring_Model_History $row        History Model
     * @return string
     */
    public function showOldContent($oldContent, FireGento_AdminMonitoring_Model_History $row)
    {
        $cell = '';
        $oldContent = $this->decodeContent($oldContent);

        if (is_array($oldContent)) {
           if (count($oldContent) > 0) {
               foreach ($oldContent as $key => $value) {
                   $attributeName = $this->getMonitoringHelper()
                       ->getAttributeNameByTypeAndCode($row->getObjectType(), $key);
                   $cell .= $this->formatCellContent($attributeName, $value);
               }
           } else {
               return $this->__('not available');
           }
        }

        return $this->wrapColor($cell, '#ff0000');
    }

    /**
     * Decode the given content string.
     *
     * @param  string $content
     * @return mixed
     */
    private function decodeContent($content)
    {
        $content = html_entity_decode($content);
        return json_decode($content, true);
    }

    /**
     * Convert special characters to HTML entities
     *
     * @param  string $string Input string
     * @return string
     */
    private function entities($string)
    {
        return htmlspecialchars($string, ENT_QUOTES|ENT_COMPAT, 'UTF-8');
    }

    /**
     * Format the cell content
     *
     * @param  array|string $value Value
     * @param  string       $key   Key
     * @return string Formatted string
     */
    private function formatCellContent($key, $value)
    {
        if (is_array($value)) {
            $value = print_r($value, true);
        }
        return  $this->entities($key . ': ' . $value) . '<br />';
    }

    /**
     * Wrap the given string in a box with a given border color.
     *
     * @param  string $string String to format
     * @param  string $color  Border color
     * @return string         Formatted string
     */
    private function wrapColor($string, $color)
    {
        $formattedString = '<div style="font-weight: bold; color: ' . $color . '; overflow: auto; ';
        $formattedString .= 'max-height: 100px; max-width: 400px;">' . $string . '</div>';

        return $formattedString;
    }
}
