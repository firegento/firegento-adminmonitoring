# Firegento AdminLogger

The admin logger logs nearly every save and delete call in the backend. The first idea was to generate an overview of the changes in the backend to know who changed certain things. This is still the actual goal.

##Vision
If we know all the changes in the backend, we can provide versioning.

## Usage
Install via modman or copy the files into your magento installation.

### Dependencies
* PHP 5.3 (or even 5.0 as long as [spl](http://www.php.net/manual/en/book.spl.php) is activated)
* Magento CE >= 1.6 OR Magento EE >= 1.12

### BE CAREFUL
This extension writes a lot of data into the database and we exclude only a few core classes. If you have many writes in the backend, please have a look into this to avoid a full hard disk!

To exclude a class, add it into the node `config/default/firegento_adminlogger_config/exclude/object_types`

    <config>
        <default>
            <firegento_adminlogger_config>
                <exclude>
                    <object_types>
                        <Mage_Index_Model_Event />
                        <!-- omit infinite loops -->
                        <Firegento_AdminLogger_Model_History />
                    </object_types>
                </exclude>
            </firegento_adminlogger_config>
        </default>
    </config>
    
## Core Team
* Tobias Zander (@airbone42)
* Ralf Siepker (@mageconsult)
* Carmen Bremen (@neoshops)
* Fabian Blechschmidt (@Schrank)