<?php

/**
 * @author Ivan Semerenko <Semerenko888@yandex.ru>
 * @copyright Copyright (c) 2017, Ivan Semerenko
 */

class SVI_GroupAdherence_Model_Resource_Adherence_Collection
    extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('svi_groupAdherence/adherence');
    }
}