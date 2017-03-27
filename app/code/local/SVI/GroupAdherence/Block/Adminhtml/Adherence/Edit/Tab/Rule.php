<?php

/**
 * @author Ivan Semerenko <Semerenko888@yandex.ru>
 * @copyright Copyright (c) 2017, Ivan Semerenko
 */

class SVI_GroupAdherence_Block_Adminhtml_Adherence_Edit_Tab_Rule
    extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('rule_form');
        $this->setTitle(Mage::helper('adherence')->__('Rule Information'));
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('adherence_rule');
        $form = new Varien_Data_Form();


        $form->setHtmlIdPrefix('rule_');

        $fieldset = $form->addFieldset('base_fieldset',
            array(
                'legend'=>Mage::helper('adherence')->__('Rule Information')
            )
        );

        $fieldset->addField('auto_apply', 'hidden', array(
            'name' => 'auto_apply',
        ));

        if ($model->getRuleId()) {
            $fieldset->addField('rule_id', 'hidden', array(
                'name' => 'rule_id',
            ));
        }

        $fieldset->addField('rule_name', 'text', array(
            'name'      => 'rule_name',
            'label'     => Mage::helper('adherence')->__('Rule`s name'),
            'title'     => Mage::helper('adherence')->__('Rule`s name'),
            'required'  => true,
        ));

        $groups = Mage::getResourceModel('customer/group_collection')
            ->load()
            ->toOptionHash();

        $fieldset->addField('group_id', 'select', array(
            'label'     => Mage::helper('adherence')->__('Move to group'),
            'title'     => Mage::helper('adherence')->__('Move to group'),
            'name'      => 'group_id',
            'required'  => true,
            'options'   => $groups,
        ));

        $fieldset->addField('groups_serialized', 'multiselect', array(
            'label'     => Mage::helper('adherence')->__('Customer Groups'),
            'title'     => Mage::helper('adherence')->__('Customer Groups'),
            'name'      => 'groups_serialized[]',
            'values'    => Mage::getResourceModel('customer/group_collection')->toOptionArray(),
            'note' => Mage::helper('adherence')
                ->__('Not choosing any one means working for all except group above(target group)'),
        ));

        if (Mage::app()->isSingleStoreMode()) {
            $websiteId = Mage::app()->getStore(true)->getWebsiteId();
            $fieldset->addField('websites_serialized', 'hidden', array(
                'name'     => 'websites_serialized[]',
                'value'    => $websiteId
            ));
            $model->setWebsitesSerialized($websiteId);
        } else {
            $field = $fieldset->addField('websites_serialized', 'multiselect', array(
                'name'     => 'websites_serialized[]',
                'label'     => Mage::helper('adherence')->__('Websites'),
                'title'     => Mage::helper('adherence')->__('Websites'),
                'values'   => Mage::getSingleton('adminhtml/system_store')->getWebsiteValuesForForm(),
                'note' => Mage::helper('adherence')
                    ->__('Not choosing any one means working for all'),
            ));
            $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
            $field->setRenderer($renderer);
        }

        $fieldset->addField('hierarchy', 'text', array(
            'label'     => Mage::helper('adherence')->__('Hierarchy'),
            'title'     => Mage::helper('adherence')->__('Hierarchy'),
            'name'      => 'hierarchy',
            'required'  => true,
        ));

        $fieldset->addField('rule_status', 'select', array(
            'label'     => Mage::helper('adherence')->__('Status'),
            'title'     => Mage::helper('adherence')->__('Status'),
            'name'      => 'rule_status',
            'required'  => true,
            'options'   => Mage::getModel('svi_groupAdherence/adminhtml_system_config_source_status')->toArray(),
        ));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
