<?php

/**
 * @author Ivan Semerenko <Semerenko888@yandex.ru>
 * @copyright Copyright (c) 2017, Ivan Semerenko
 */

class Group_Adherence_Block_Adminhtml_Adherence_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'rule_id';
        $this->_controller = 'adminhtml_adherence';
        $this->_blockGroup = 'adherence';

        parent::__construct();

        $this->_addButton('save_apply', array(
            'class'   => 'save',
            'label'   => Mage::helper('adherence')->__('Save and Apply'),
            'onclick' => "$('rule_auto_apply').value=1; editForm.submit()",
        ));

        $this->_updateButton('save', 'label', Mage::helper('adherence')->__('Save Rule'));
        $this->_updateButton('delete', 'label', Mage::helper('adherence')->__('Delete Rule'));

        $this->_addButton('save_and_continue_edit', array(
            'class'   => 'save',
            'label'   => Mage::helper('adherence')->__('Save and Continue Edit'),
            'onclick' => 'editForm.submit($(\'edit_form\').action + \'back/edit/\')',
        ), 10);
    }

    public function getHeaderText()
    {
        if (Mage::registry('adherence_rule')->getId()) {

            return Mage::helper('adherence')
                ->__("Edit Rule '%s'", $this->escapeHtml(Mage::registry('adherence_rule')
                    ->getRuleName()));
        }
        else {
            return Mage::helper('adherence')->__('New Rule');
        }
    }
}
