<?php
class Group_Adherence_Model_Adherence extends Mage_Rule_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('group_adherence/adherence');
    }

    public function getConditionsInstance()
    {
        return Mage::getModel('catalogrule/rule_condition_combine');
    }

    /**
     * Getter for rule actions collection
     *
     * @return Mage_CatalogRule_Model_Rule_Action_Collection
     */
    public function getActionsInstance()
    {
        return Mage::getModel('catalogrule/rule_action_collection');
    }

    protected function _beforeSave()
    {
        parent::_beforeSave();
        if (is_array($this->getData('groups_serialized'))) {
            $this->setData('groups_serialized',serialize($this->getData('groups_serialized')));
        }

        if (is_array($this->getData('websites_serialized'))) {
            $this->setData('websites_serialized',serialize($this->getData('websites_serialized')));
        }
    }

    protected function _afterLoad()
    {
        parent::_afterLoad();
        if (is_string($this->getData('groups_serialized'))) {
            $this->setData('groups_serialized',unserialize($this->getData('groups_serialized')));
        }

        if (is_string($this->getData('websites_serialized'))) {
            $this->setData('websites_serialized',unserialize($this->getData('websites_serialized')));
        }
    }
}
