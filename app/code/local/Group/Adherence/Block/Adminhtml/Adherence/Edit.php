<?php

class Group_Adherence_Block_Adminhtml_Adherence_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'rule_id';
        $this->_controller = 'adminhtml_adherence';
        $this->_blockGroup = 'adherence';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('adherence')->__('Save Rule'));
        $this->_updateButton('delete', 'label', Mage::helper('adherence')->__('Delete Rule'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('adherence_rule')->getId()) {

            return Mage::helper('adherence')->__("Edit Rule '%s'", $this->escapeHtml(Mage::registry('adherence_rule')->getRuleName()));
        }
        else {
            return Mage::helper('adherence')->__('New Rule');
        }
    }

}
