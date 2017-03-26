<?php

/**
 * @author Ivan Semerenko <Semerenko888@yandex.ru>
 * @copyright Copyright (c) 2017, Ivan Semerenko
 */

class Group_Adherence_Block_Adminhtml_Adherence_Edit_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('rule_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('adherence')->__('Manage Rules'));
    }

    protected function _prepareLayout()
    {
        $this->addTab('rule_tab', array(
            'label'     => $this->__('Rule Information'),
            'title'     => $this->__('Rule Information'),
            'content'   => $this->getLayout()
                ->createBlock('adherence/adminhtml_adherence_edit_tab_rule')
                ->toHtml()
        ));

        $this->addTab('conditions_tab', array(
            'label'     => $this->__('Rule condition'),
            'title'     => $this->__('Rule condition'),
            'content'   => $this->getLayout()
                ->createBlock('adherence/adminhtml_adherence_edit_tab_conditions')
                ->toHtml()
        ));

        return parent::_prepareLayout();
    }
}
