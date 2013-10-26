# Firegento AdminMonitoring

The admin monitoring logs nearly every save and delete call in the backend. The idea is to generate an overview of the changes in the backend to know who changed certain things.

##Vision
If we know all the changes in the backend, we can provide versioning.

## Usage
Install via modman or copy the files into your magento installation.

### Dependencies
* PHP 5.3 (or even 5.0 as long as [spl](http://www.php.net/manual/en/book.spl.php) is activated)
* Magento CE >= 1.6 OR Magento EE >= 1.12

### BE CAREFUL
This extension writes a lot of data into the database and we exclude only a few core classes. If you have many writes in the backend, please have a look into this to avoid a full hard disk!

To exclude a class, add it into the node `config/default/firegento_adminmonitoring_config/exclude/object_types`

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

You can also exclude fields like updated_at ...

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

### Third party integration
model_save_after and model_delete_after are observed and changes automatically logged if not excluded as described above.
So even third party models will be logged and can be even better integrated by link to their adminhtml edit form.
To do this observe the firegento_AdminMonitoring_rowurl event and see Firegento_AdminMonitoring_Model_RowUrl_Product for an catalog_product implementation which can be adapted.

If you want to log your own events just dispatch the firegento_AdminMonitoring_log event:

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

## Core Team
* Tobias Zander (@airbone42)
* Ralf Siepker (@mageconsult)
* Carmen Bremen (@neoshops)
* Fabian Blechschmidt (@Schrank)