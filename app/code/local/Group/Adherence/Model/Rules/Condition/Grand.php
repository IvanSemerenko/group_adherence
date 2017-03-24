<?php

class Group_Adherence_Model_Rules_Condition_Grand
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
        $attributes['sum_for_period'] = Mage::helper('adherence')->__('Sum For Period');
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
        $html = Mage::helper('adherence')->__('of base currency for last:').
            $this->getValueElementPeriodValue()->getHtml().Mage::helper('adherence')->__('days').' 
     <span class="rule-param"><a href="javascript:void(0)" class="rule-param-remove" title="'
            . Mage::helper('core')->quoteEscape(Mage::helper('rule')->__('Remove'))
            . '"><img src="' . $src . '"  alt="" class="v-middle" /></a></span>';
        return $html;
    }

    public function getValueElementPeriodValue()
    {
        $elementParams = array(
            'name'               => 'rule[' . $this->getPrefix() . '][' . $this->getId() . '][period_value]',
            'value'              => $this->getPeriodValue(),
            'values'             => $this->getValueSelectOptions(),
            'value_name'         => $this->getPeriodValueName(),
            'after_element_html' => $this->getValueAfterElementHtml(),
            'explicit_apply'     => $this->getExplicitApply(),
        );

        return $this->getForm()->addField($this->getPrefix() . '__' . $this->getId() . '__period_value',
            $this->getValueElementType(),
            $elementParams
        )->setRenderer($this->getValueElementRenderer());
    }

    public function loadArray($arr)
    {
        parent::loadArray($arr);

        $this->setPeriodValue(isset($arr['period_value']) ? $arr['period_value'] : false);

        return $this;
    }

    public function asArray(array $arrAttributes = array())
    {
        $out = array(
            'type'               => $this->getType(),
            'attribute'          => $this->getAttribute(),
            'operator'           => $this->getOperator(),
            'value'              => $this->getValue(),
            'period_value'       => $this->getPeriodValue(),
            'is_value_processed' => $this->getIsValueParsed(),
        );

        return $out;
    }

    public function getPeriodValueName()
    {
        $value = $this->getPeriodValue();

        if (is_null($value) || '' === $value) {
            return '...';
        }

        return $value;
    }
}