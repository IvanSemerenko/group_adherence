<?php
class Group_Adherence_Model_Resource_Adherence_Collection
    extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('group_adherence/adherence');
    }
}