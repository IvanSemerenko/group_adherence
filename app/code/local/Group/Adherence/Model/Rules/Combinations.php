<?php

class Group_Adherence_Model_Rules_Combinations
    extends Mage_Rule_Model_Condition_Combine
{
    public function __construct()
    {
        parent::__construct();
        $this->setType('group_adherence/rules_combinations');
    }

    public function getNewChildSelectOptions()
    {
        $grandPeriod = Mage::getModel('group_adherence/rules_condition_grand');
        $grandTotal = Mage::getModel('group_adherence/rules_condition_total');
        $user = Mage::getModel('group_adherence/rules_condition_user');


        $grandPeriodAttributes = $grandPeriod->loadAttributeOptions()->getAttributeOption();
        $grandTotalAttributes = $grandTotal->loadAttributeOptions()->getAttributeOption();
        $userAttributes = $user->loadAttributeOptions()->getAttributeOption();

        $grandPeriodAtt = array();
        $totalAtt = array();
        $userAtt = array();

        foreach ($grandPeriodAttributes as $code=> $label) {
            $grandPeriodAtt[] = array('value'=>'group_adherence/rules_condition_grand|'.$code, 'label'=>$label);
        }

        foreach ($grandTotalAttributes as $code=> $label) {
            $totalAtt[] = array('value'=>'group_adherence/rules_condition_total|'.$code, 'label'=>$label);
        }

        foreach ($userAttributes as $code=> $label) {
            $userAtt[] = array('value'=>'group_adherence/rules_condition_user|'.$code, 'label'=>$label);
        }

        $conditions = parent::getNewChildSelectOptions();

        $conditions = array_merge_recursive($conditions, array(
            array('value'=>'group_adherence/rules_combinations', 'label'=>Mage::helper('adherence')
                ->__('Conditions Combination')),
            array('label'=>Mage::helper('adherence')->__('Grand Total For Period'), 'value'=> $grandPeriodAtt),
            array('label'=>Mage::helper('adherence')->__('Grand Total'), 'value'=> $totalAtt),
            array('label'=>Mage::helper('adherence')->__('User'), 'value'=> $userAtt),
        ));

        return $conditions;
    }

    public function collectValidatedAttributes($customerCollection)
    {
        foreach ($this->getConditions() as $condition) {
            $condition->collectValidatedAttributes($customerCollection);
        }

        return $this;
    }
}