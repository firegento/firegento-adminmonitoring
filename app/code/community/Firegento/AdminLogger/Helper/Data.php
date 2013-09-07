<?php
class Firegento_AdminLogger_Helper_Data extends Mage_Core_Helper_Abstract
{
    const SCOPE_GLOBAL = 0;
    const SCOPE_WEBSITE = 1;
    const SCOPE_STORE = 2;
    const SCOPE_STORE_VIEW = 3;

    const ACTION_INSERT = 1;
    const ACTION_UPDATE = 2;
    const ACTION_DELETE = 3;
}