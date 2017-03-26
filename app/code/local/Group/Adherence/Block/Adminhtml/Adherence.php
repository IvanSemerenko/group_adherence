<?php

/**
 * @author Ivan Semerenko <Semerenko888@yandex.ru>
 * @copyright Copyright (c) 2017, Ivan Semerenko
 */

class Group_Adherence_Block_Adminhtml_Adherence
    extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_addButton('apply_rules', array(
            'label'     => Mage::helper('adherence')->__('Apply Rules'),
            'onclick'   => "location.href='".$this->getUrl('*/*/applyRules')."'",
            'class'     => '',
        ));

        $this->_controller = 'adminhtml_adherence';
        $this->_blockGroup = 'adherence';
        $this->_headerText = Mage::helper('adherence')->__('Rules Manager');
        $this->_addButtonLabel = Mage::helper('adherence')->__('Add New Rule');
        parent::__construct();
    }
}
