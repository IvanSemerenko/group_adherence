<?php

class Group_Adherence_Model_Rules_Condition_Total
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
        $attributes['sum_for_period'] = Mage::helper('adherence')->__('Sum For All Time');
    }

    public function loadAttributeOptions()
    {
        $attributes = array();

        $this->_addSpecialAttributes($attributes);

        $this->setAttributeOption($attributes);

        return $this;
    }
}