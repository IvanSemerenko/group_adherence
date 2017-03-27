<?php

/**
 * @author Ivan Semerenko <Semerenko888@yandex.ru>
 * @copyright Copyright (c) 2017, Ivan Semerenko
 */

class SVI_GroupAdherence_Model_Rules_Condition_Total
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
        $attributes['sum_for_all_period'] = Mage::helper('adherence')->__('Sum For All Time');
    }

    public function loadAttributeOptions()
    {
        $attributes = array();
        $this->_addSpecialAttributes($attributes);
        $this->setAttributeOption($attributes);

        return $this;
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
        $orders = Mage::getModel('sales/order')->getCollection()
            ->addFieldToSelect('*')
            ->addFieldToFilter('status', 'complete')
            ->addFieldToFilter('customer_id', $object->entityId);

        $sum = 0;
        foreach ($orders as $order) {
            $total = $order->getGrandTotal();
            $sum += $total;
        }

        return $sum;
    }
}