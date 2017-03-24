<?php

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
        $html = ' '.Mage::helper('adherence')->__('days ago').' 
        <span class="rule-param"><a href="javascript:void(0)" class="rule-param-remove" title="'
            . Mage::helper('core')->quoteEscape(Mage::helper('rule')->__('Remove'))
            . '"><img src="' . $src . '"  alt="" class="v-middle" /></a></span>';
        return $html;
    }
}