<?php
class Group_Adherence_Model_Resource_Adherence
    extends Mage_Core_Model_Mysql4_Abstract
{

    public function _construct()
    {
        $this->_init('group_adherence/adherence','rule_id');
    }
}