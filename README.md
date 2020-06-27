FireGento_AdminMonitoring
<!-- ALL-CONTRIBUTORS-BADGE:START - Do not remove or modify this section -->
[![All Contributors](https://img.shields.io/badge/all_contributors-12-orange.svg?style=flat-square)](#contributors-)
<!-- ALL-CONTRIBUTORS-BADGE:END -->
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

## Contributors ✨

Thanks goes to these wonderful people ([emoji key](https://allcontributors.org/docs/en/emoji-key)):

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tr>
    <td align="center"><a href="http://www.fabian-blechschmidt.de/"><img src="https://avatars1.githubusercontent.com/u/379680?v=4" width="100px;" alt=""/><br /><sub><b>Fabian Blechschmidt</b></sub></a><br /><a href="https://github.com/firegento/firegento-adminmonitoring/commits?author=Schrank" title="Code">💻</a></td>
    <td align="center"><a href="https://rouven.io/"><img src="https://avatars3.githubusercontent.com/u/393419?v=4" width="100px;" alt=""/><br /><sub><b>Rouven Alexander Rieker</b></sub></a><br /><a href="https://github.com/firegento/firegento-adminmonitoring/commits?author=therouv" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/mryvlin"><img src="https://avatars3.githubusercontent.com/u/3071413?v=4" width="100px;" alt=""/><br /><sub><b>Michael Ryvlin</b></sub></a><br /><a href="https://github.com/firegento/firegento-adminmonitoring/commits?author=mryvlin" title="Code">💻</a></td>
    <td align="center"><a href="http://neoshops.de/"><img src="https://avatars0.githubusercontent.com/u/3316754?v=4" width="100px;" alt=""/><br /><sub><b>Carmen</b></sub></a><br /><a href="https://github.com/firegento/firegento-adminmonitoring/commits?author=neoshops" title="Code">💻</a></td>
    <td align="center"><a href="https://janpapenbrock.de/"><img src="https://avatars1.githubusercontent.com/u/2108728?v=4" width="100px;" alt=""/><br /><sub><b>Jan Papenbrock</b></sub></a><br /><a href="https://github.com/firegento/firegento-adminmonitoring/commits?author=janpapenbrock" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/dh1984"><img src="https://avatars1.githubusercontent.com/u/6348686?v=4" width="100px;" alt=""/><br /><sub><b>Daniel</b></sub></a><br /><a href="https://github.com/firegento/firegento-adminmonitoring/commits?author=dh1984" title="Code">💻</a></td>
    <td align="center"><a href="https://copex.io/"><img src="https://avatars1.githubusercontent.com/u/584168?v=4" width="100px;" alt=""/><br /><sub><b>Roman Hutterer</b></sub></a><br /><a href="https://github.com/firegento/firegento-adminmonitoring/commits?author=roman204" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="http://elgentos.nl/"><img src="https://avatars2.githubusercontent.com/u/431360?v=4" width="100px;" alt=""/><br /><sub><b>Peter Jaap Blaakmeer</b></sub></a><br /><a href="https://github.com/firegento/firegento-adminmonitoring/commits?author=peterjaap" title="Code">💻</a></td>
    <td align="center"><a href="http://milandavidek.cz/"><img src="https://avatars2.githubusercontent.com/u/4263992?v=4" width="100px;" alt=""/><br /><sub><b>Milan Davídek</b></sub></a><br /><a href="https://github.com/firegento/firegento-adminmonitoring/commits?author=midlan" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/michael-sauerwald"><img src="https://avatars2.githubusercontent.com/u/1592971?v=4" width="100px;" alt=""/><br /><sub><b>michael-sauerwald</b></sub></a><br /><a href="https://github.com/firegento/firegento-adminmonitoring/commits?author=michael-sauerwald" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/dimajanzen"><img src="https://avatars1.githubusercontent.com/u/156927?v=4" width="100px;" alt=""/><br /><sub><b>dimajanzen</b></sub></a><br /><a href="https://github.com/firegento/firegento-adminmonitoring/commits?author=dimajanzen" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/kkrieger85"><img src="https://avatars2.githubusercontent.com/u/4435523?v=4" width="100px;" alt=""/><br /><sub><b>Kevin Krieger</b></sub></a><br /><a href="https://github.com/firegento/firegento-adminmonitoring/commits?author=kkrieger85" title="Documentation">📖</a></td>
  </tr>
</table>

<!-- markdownlint-enable -->
<!-- prettier-ignore-end -->
<!-- ALL-CONTRIBUTORS-LIST:END -->

This project follows the [all-contributors](https://github.com/all-contributors/all-contributors) specification. Contributions of any kind welcome!