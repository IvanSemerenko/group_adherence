<?php

class Group_Adherence_Block_Adminhtml_Adherence extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_adherence';
        $this->_blockGroup = 'adherence';
        $this->_headerText = Mage::helper('adherence')->__('Rules Manager');
        $this->_addButtonLabel = Mage::helper('adherence')->__('Add New Rule');
        parent::__construct();
    }
}
