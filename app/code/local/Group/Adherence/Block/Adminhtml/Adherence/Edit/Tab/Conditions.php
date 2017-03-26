<?php

/**
 * @author Ivan Semerenko <Semerenko888@yandex.ru>
 * @copyright Copyright (c) 2017, Ivan Semerenko
 */

class Group_Adherence_Block_Adminhtml_Adherence_Edit_Tab_Conditions
    extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('conditions_form');
        $this->setTitle(Mage::helper('adherence')->__('Rule Condition'));
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('adherence_rule');
        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('conditions_');

        $model->getConditions()->setJsFormObject('block_conditions_fieldset');

        $renderer = Mage::getBlockSingleton('adminhtml/widget_form_renderer_fieldset')
            ->setTemplate('promo/fieldset.phtml')
            ->setNewChildUrl($this->getUrl('*/promo_catalog/newConditionHtml/form/block_conditions_fieldset'));

        $conditionsFieldset = $form->addFieldset('conditions_fieldset',
            array(
                'legend'=>Mage::helper('adherence')->__('Conditions'),
                'class' => 'fieldset-wide')
        )->setRenderer($renderer);
        $conditionsFieldset->addField('conditions', 'text', array(
            'name' => 'conditions',
            'label' => Mage::helper('adherence')->__('Conditions'),
            'title' => Mage::helper('adherence')->__('Conditions'),
            'required' => true,
        ))->setRule($model)->setRenderer(Mage::getBlockSingleton('rule/conditions'));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
