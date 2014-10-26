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
 * @copyright 2014 FireGento Team (http://www.firegento.com)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 */

/**
 * Block for showing information on the history detail page
 *
 * @category FireGento
 * @package  FireGento_AdminMonitoring
 * @author   FireGento Team <team@firegento.com>
 */
class FireGento_AdminMonitoring_Block_Adminhtml_History_View_Detail extends Mage_Adminhtml_Block_Template
{
    /**
     * Retrieve the history model
     *
     * @return FireGento_AdminMonitoring_Model_History
     */
    public function getHistory()
    {
        return Mage::registry('current_history');
    }

    /**
     * Retrieve the adminmonitoring helper
     *
     * @return FireGento_AdminMonitoring_Helper_Data
     */
    public function getMonitoringHelper()
    {
        return Mage::helper('firegento_adminmonitoring');
    }

    /**
     * Retrieve the admin user model
     *
     * @return Mage_Admin_Model_User|bool
     */
    public function getAdminUser()
    {
        $user = Mage::getModel('admin/user')->load($this->getHistory()->getUserId());
        if (!$user->getId()) {
            return false;
        }

        return $user;
    }

    /**
     * Retrieve the admin user name
     *
     * @return string
     */
    public function getAdminUserName()
    {
        if ($adminUser = $this->getAdminUser()) {
            return $adminUser->getUsername();
        }

        return '';
    }

    /**
     * Retrieve the link to the object
     *
     * @return string
     */
    public function getObjectLink()
    {
        /* @var $helper FireGento_AdminMonitoring_Helper_Data */
        $helper = Mage::helper('firegento_adminmonitoring');

        return $helper->getRowUrl($this->getHistory());
    }

    /**
     * Retrieve the history message
     *
     * @return string
     */
    public function getMessage()
    {
        if ($message = $this->getHistory()->getData('history_message')) {
            return $message;
        }

        return '-';
    }

    /**
     * Show the new content after the changes.
     *
     * @return string
     */
    public function getNewContent()
    {
        if ($this->getHistory()->isDelete()) {
            return '';
        }

        $cell = '';
        $oldContent = $this->getHistory()->getContentDiff();
        $oldContent = $this->decodeContent($oldContent);
        $newContent = $this->decodeContent($this->getHistory()->getContent());

        if (is_array($oldContent) && is_array($newContent)) {
            if (count($oldContent) > 0) {
                $showContent = $oldContent;
            } else {
                $showContent = $newContent;
            }
            foreach ($showContent as $key => $value) {
                if (array_key_exists($key, $newContent)) {
                    $attributeName = $this->getMonitoringHelper()
                        ->getAttributeNameByTypeAndCode($this->getHistory()->getObjectType(), $key);
                    $cell .= $this->formatCellContent($attributeName, $newContent[$key]);
                }
            }
        }

        return $this->wrapColor($cell, '#009900');
    }

    /**
     * Show the old content before the changes.
     *
     * @return string
     */
    public function getOldContent()
    {
        $oldContent = $this->getHistory()->getContentDiff();
        $cell = '';
        $oldContent = $this->decodeContent($oldContent);

        if (is_array($oldContent)) {
            if (count($oldContent) > 0) {
                foreach ($oldContent as $key => $value) {
                    $attributeName = $this->getMonitoringHelper()
                        ->getAttributeNameByTypeAndCode($this->getHistory()->getObjectType(), $key);
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
     * @param  string $content Content to decode
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
        return htmlspecialchars($string, ENT_QUOTES | ENT_COMPAT, 'UTF-8');
    }

    /**
     * Format the cell content
     *
     * @param  string       $key   Key
     * @param  array|string $value Value
     * @return string Formatted string
     */
    private function formatCellContent($key, $value)
    {
        if (is_array($value)) {
            $value = print_r($value, true);
        }

        return $this->entities($key . ': ' . $value) . '<br />';
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
        $formattedString = sprintf(
            '<div style="font-weight: bold; color: %s; overflow: auto; ">%s</div>',
            $color,
            $string
        );

        return $formattedString;
    }
}
