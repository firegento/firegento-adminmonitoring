FireGento_AdminMonitoring
=========================

The admin monitoring allows an shop owner to log almost every activity in the backend.

Facts
-----
- Version: check [config.xml](https://github.com/firegento/firegento-adminmonitoring/blob/master/src/app/code/community/FireGento/AdminMonitoring/etc/config.xml)
- [Extension on GitHub](https://github.com/firegento/firegento-adminmonitoring/)

Builds
------
- Branch: master [![Build Status](https://travis-ci.org/firegento/firegento-adminmonitoring.png?branch=master)](https://travis-ci.org/firegento/firegento-adminmonitoring)
- Branch: develop [![Build Status](https://travis-ci.org/firegento/firegento-adminmonitoring.png?branch=develop)](https://travis-ci.org/firegento/firegento-adminmonitoring)

Description
-----------
The admin monitoring allows an shop owner to log almost every activity in the backend. The goal is to monitor all changes in the backend and show them in a nice view so that
a shop owner can monitor who changed what, e.g. logged in to the admin account, saved a product, deleted a customer, e.g.

### BE CAREFUL
This extension writes a lot of data into the database and we exclude only a few core classes. If you have many writes in the backend, please have a look into this to avoid a full hard disk!

There are currently several ways if you can exclude e.g. specific models, admin routes, field names from logging data to the database:
- Exclude all changes from a specific object (e.g. Mage_Index_Model_Event)
- Exclude all changes from a specific admin route (e.g. admin_sales_order_create_loadBlock)
- Exclude specific objects from specific admin routes (e.g. Mage_CatalogRule_Model_Flag from admin_promo_catalog_save)
- Exclude specific field names from every object (e.g. created_at, updated_at)

There is a basic *adminmonitoring.xml* file located in the "etc" folder of this extension with the following default excludes:

```xml
<?xml version="1.0"?>
<config>
    <adminmonitoring>
        <excludes>
            <object_types>
                <Mage_Index_Model_Event/>
                <Mage_Admin_Model_User/>
                <Enterprise_Logging_Model_Event_Changes/>
                <Enterprise_Logging_Model_Event/>
                <!-- omit infinite loops -->
                <FireGento_AdminMonitoring_Model_History/>
            </object_types>
            <fields>
                <created_at/>
                <updated_at/>
                <create_time/>
                <update_time/>
                <low_stock_date/>
            </fields>
            <admin_routes>
                <admin_sales_order_create_index/>
                <admin_sales_order_create_loadBlock/>
                <admin_sales_order_create_save/>
                <admin_sales_order_invoice_save/>
                <admin_sales_order_shipment_save/>
                <admin_sales_order_creditmemo_save/>
                <admin_sales_order_create_reorder/>
                <admin_promo_catalog_save>
                    <Mage_CatalogRule_Model_Flag/>
                </admin_promo_catalog_save>
            </admin_routes>
        </excludes>
    </adminmonitoring>
</config>
```


### Third party integration

Events for model_save_after and model_delete_after are observed and changes automatically logged, if not excluded as described above.
So even third party models will be logged and can be even better integrated by link to their adminhtml edit form.
To do this observe the event **firegento_adminmonitoring_rowurl** and see **Firegento_AdminMonitoring_Model_RowUrl_Product** for an catalog_product implementation which can be adapted for your custom models.

If you want to log your own events just dispatch the event **firegento_adminmonitoring_log** and pass your custom data:

```php
Mage::dispatchEvent(
    'firegento_adminmonitoring_log',
    array(
        'object_id'    => $objectId,
        'object_type'  => $objectType,
        'content'      => $content, // as json
        'content_diff' => $contentDiff, // as json
        'action'       => $action, // see Firegento_AdminMonitoring_Helper_Data for possible ACTION constants
    )
);
```

If you want to exclude some more fields, admin routes, object types just create a custom *adminmonitoring.xml* file 
in your custom module and add the necessary values in the same structure like in the default *adminmonitoring.xml* file of this extension.


Requirements
------------
- PHP >= 5.3.0 (or even 5.0 as long as [spl](http://www.php.net/manual/en/book.spl.php) is activated)
- PHP >= 5.5.0: json extension

Compatibility
-------------
- Magento CE >= 1.6
- Magento EE >= 1.12

Installation Instructions
-------------------------
1. Install the extension by copying all the extension files into your document root.
2. Clear the cache, logout from the admin panel and then login again.
3. You can now configure the extenion via *System -> Configuration -> Advanced -> Admin -> Admin Monitoring*
4. You can view all logging entries in *System -> Configuration -> Admin Monitoring*

Uninstallation
--------------
1. Remove all extension files from your Magento installation
2. Run the following sql script in your database:

```sql
DROP TABLE 'firegento_adminmonitoring_history';
```

3. Please remove all integration for the admin monitoring in your custom modules.

Support
-------
If you have any issues with this extension, open an issue on [GitHub](https://github.com/firegento/firegento-adminmonitoring/issues).

Contribution
------------
Any contribution is highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developer
---------
FireGento Team
* Website: [http://firegento.com](http://firegento.com)
* Twitter: [@firegento](https://twitter.com/firegento)

Developers:
* Please see the [contributor page](https://github.com/firegento/firegento-adminmonitoring/graphs/contributors) on github.

License
-------
[GNU General Public License, version 3 (GPLv3)](http://opensource.org/licenses/gpl-3.0)

Copyright
---------
(c) 2013-2014 FireGento Team
