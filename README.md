# Firegento AdminLogger

The admin logger logs nearly every save and delete call in the backend. The first idea was to generate an overview of the changes in the backend to know who changed certain things. This is still the actual goal.

##Vision
If we know all the changes in the backend, we can provide versioning.

## Usage
Install via modman or copy the files into your magento installation.

### BE CAREFUL
This extension writes a lot of data into the database and we exclude only a few core classes. If you have many writes in the backend, please have a look into this to avoid a full hard disk!

## Core Team
* Tobias Zander (@airbone42)
* Ralf Siepker (@mageconsult)
* Carmen Bremen (@neoshops)
* Fabian Blechschmidt (@Schrank)