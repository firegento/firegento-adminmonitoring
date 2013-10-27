FireGento_AdminMonitoring
=========================

The admin monitoring logs nearly every save and delete call in the backend.

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
The admin monitoring logs nearly every save and delete call in the backend. The idea is to generate an overview of the changes in the backend to know who changed certain things.

### BE CAREFUL
This extension writes a lot of data into the database and we exclude only a few core classes. If you have many writes in the backend, please have a look into this to avoid a full hard disk!

To exclude a class, add it into the node `config/default/firegento_adminmonitoring_config/exclude/object_types`

```xml
<config>
    <default>
        <firegento_adminmonitoring_config>
            <exclude>
                <object_types>
                    <Mage_Index_Model_Event />
                    <!-- omit infinite loops -->
                    <Firegento_AdminMonitoring_Model_History />
                </object_types>
            </exclude>
        </firegento_adminmonitoring_config>
    </default>
</config>
```

You can also exclude fields like updated_at ...

```xml
<config>
    <default>
        <firegento_adminmonitoring_config>
            <exclude>
                <fields>
                    <updated_at />
                    <update_time />
                </fields>
            </exclude>
        </firegento_adminmonitoring_config>
    </default>
</config>
```

### Third party integration

Events for model_save_after and model_delete_after are observed and changes automatically logged, if not excluded as described above.
So even third party models will be logged and can be even better integrated by link to their adminhtml edit form.
To do this observe the firegento_AdminMonitoring_rowurl event and see Firegento_AdminMonitoring_Model_RowUrl_Product for an catalog_product implementation which can be adapted.

If you want to log your own events just dispatch the firegento_AdminMonitoring_log event:

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

Requirements
------------
- PHP >= 5.3.0 (or even 5.0 as long as [spl](http://www.php.net/manual/en/book.spl.php) is activated)

Compatibility
-------------
- Magento CE >= 1.6
- Magento EE >= 1.12

Installation Instructions
-------------------------
1. Install the extension by copying all the extension files into your document root.
2. Clear the cache, logout from the admin panel and then login again.
3. You can now configure the extenion via *System -> Configuration -> Advanced -> Admin -> Admin Monitoring*

Uninstallation
--------------
1. Remove all extension files from your Magento installation
2. Run the following sql script in your database:

```sql
DROP TABLE 'firegento_adminmonitoring_history';
```

Support
-------
If you have any issues with this extension, open an issue on [GitHub](https://github.com/firegento/firegento-customer/issues).

Contribution
------------
Any contribution is highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developer
---------
FireGento Team
* Website: [http://firegento.com](http://firegento.com)
* Twitter: [@firegento](https://twitter.com/firegento)

Developers:
* Tobias Zander (@airbone42)
* Ralf Siepker (@mageconsult)
* Carmen Bremen (@neoshops)
* Fabian Blechschmidt (@Schrank)

License
-------
[GNU General Public License, version 3 (GPLv3)](http://opensource.org/licenses/gpl-3.0)

Copyright
---------
(c) 2013 FireGento Team
