<?php

/**
 * @author Ivan Semerenko <Semerenko888@yandex.ru>
 * @copyright Copyright (c) 2017, Ivan Semerenko
 */

class Group_Adherence_Model_Rules_Condition_User
    extends Mage_Rule_Model_Condition_Abstract
{
    public function getDefaultOperatorInputByType()
    {
        $this->_defaultOperatorInputByType = array(
            'string' => array('==', '!=', '>=', '>', '<=', '<'),
        );

        return $this->_defaultOperatorInputByType;
    }

    protected function _addSpecialAttributes(array &$attributes)
    {
        $attributes['register'] = Mage::helper('adherence')->__('Registered');
    }

    public function loadAttributeOptions()
    {
        $attributes = array();
        $this->_addSpecialAttributes($attributes);
        $this->setAttributeOption($attributes);

        return $this;
    }

    public function getRemoveLinkHtml()
    {
        $src = Mage::getDesign()->getSkinUrl('images/rule_component_remove.gif');
        $html = ' ' . Mage::helper('adherence')->__('days ago') . ' 
        <span class="rule-param"><a href="javascript:void(0)" class="rule-param-remove" title="'
            . Mage::helper('core')->quoteEscape(Mage::helper('rule')->__('Remove'))
            . '"><img src="' . $src . '"  alt="" class="v-middle" /></a></span>';
        return $html;
    }

    public function collectValidatedAttributes($customerCollection)
    {
        $attribute = $this->getAttribute();
        $attributes = $this->getRule()->getCollectedAttributes();
        $attributes[$attribute] = true;
        $this->getRule()->setCollectedAttributes($attributes);
        $customerCollection->addAttributeToSelect($attribute);

        return $this;
    }

    public function validate(Varien_Object $object)
    {
        $attrCode = $this->getAttribute();
        $object->setData($attrCode, $this->_getAttributeValue($object));
        $result = $this->_validateCustomer($object);

        return (bool)$result;
    }

    protected function _validateCustomer($object)
    {
        return Mage_Rule_Model_Condition_Abstract::validate($object);
    }

    protected function _getAttributeValue($object)
    {
        $value = $object->getData('created_at');
        $value = $this->_prepareDatetimeValue($value);

        return $value;
    }

    protected function _prepareDatetimeValue($value)
    {
        $days = date_diff(new DateTime(), new DateTime($value))->days;

        return $days;
    }
}