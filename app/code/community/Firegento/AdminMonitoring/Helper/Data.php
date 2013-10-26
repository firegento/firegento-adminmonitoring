<?php
class Firegento_AdminMonitoring_Helper_Data extends Mage_Core_Helper_Abstract
{
    const SCOPE_GLOBAL = 0;
    const SCOPE_WEBSITE = 1;
    const SCOPE_STORE = 2;
    const SCOPE_STORE_VIEW = 3;

    const ACTION_INSERT = 1;
    const ACTION_UPDATE = 2;
    const ACTION_DELETE = 3;

    /**
     * returns attribute type by provided class name
     *
     * @param string $className
     * @return string|bool
     */
    protected function getAttributeTypeByClassName($className){
        /** @var Mage_Eav_Model_Resource_Entity_Type_Collection $typesCollection */
        $typesCollection = Mage::getModel('eav/entity_type')->getCollection();
        foreach ($typesCollection->getItems() as $type){
            /** @var Mage_Eav_Model_Entity_Type $type */
            if ($type->getEntityModel() && Mage::getModel($type->getEntityModel()) instanceof $className){
                return $type->getEntityTypeCode();
            }
        }

        return false;
    }

    /**
     * returns attribute name by provided class name and attribute code
     *
     * @param string $className
     * @param string $attributeCode
     * @return string
     */
    public function getAttributeNameByTypeAndCode($className, $attributeCode) {

        $attributeName = $attributeCode;

        $type = $this->getAttributeTypeByClassName($className);
        if ($type) {
            /** @var Mage_Eav_Model_Entity_Attribute $attribute */
            $attribute = Mage::getModel('eav/entity_attribute')->loadByCode($type, $attributeCode);
            if ($attribute->getFrontendLabel()){
                $attributeName = $attribute->getFrontendLabel();
            }
        }

        return $attributeName;
    }

}