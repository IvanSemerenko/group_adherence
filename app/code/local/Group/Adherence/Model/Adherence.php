<?php

/**
 * @author Ivan Semerenko <Semerenko888@yandex.ru>
 * @copyright Copyright (c) 2017, Ivan Semerenko
 */

class Group_Adherence_Model_Adherence
    extends Mage_Rule_Model_Abstract
{
    protected $_customerIds;

    public function _construct()
    {
        parent::_construct();
        $this->_init('group_adherence/adherence');
    }

    public function getConditionsInstance()
    {
        return Mage::getModel('group_adherence/rules_combinations');
    }

    public function getActionsInstance()
    {
        return Mage::getModel('catalogrule/rule_action_collection');
    }

    protected function _beforeSave()
    {
        parent::_beforeSave();
        if (is_array($this->getData('groups_serialized'))) {
            $this->setData('groups_serialized', serialize($this->getData('groups_serialized')));
        }

        if (is_array($this->getData('websites_serialized'))) {
            $this->setData('websites_serialized', serialize($this->getData('websites_serialized')));
        }
    }

    protected function _afterLoad()
    {
        parent::_afterLoad();
        if (is_string($this->getData('groups_serialized'))) {
            $this->setData('groups_serialized', unserialize($this->getData('groups_serialized')));
        }

        if (is_string($this->getData('websites_serialized'))) {
            $this->setData('websites_serialized', unserialize($this->getData('websites_serialized')));
        }
    }

    public function getGroupsSerialized()
    {
        if (is_string($this->getData('groups_serialized'))) {
            $groupIds = unserialize($this->getData('groups_serialized'));
            if (!empty($groupIds)) {
                $this->setData('groups_serialized', $groupIds);
            } else {
                $this->setData('groups_serialized', '');
            }
        }

        return $this->getData('groups_serialized');
    }

    public function getWebsitesSerialized()
    {
        if (is_string($this->getData('websites_serialized'))) {
            $websiteIds = unserialize($this->getData('websites_serialized'));
            if (!empty($websiteIds)) {
                $this->setData('websites_serialized', $websiteIds);
            } else {
                $this->setData('websites_serialized', '');
            }
        }

        return $this->getData('websites_serialized');
    }

    public function applyAll()
    {
        Mage::getModel('group_adherence/adherence')
            ->getCollection()
            ->setOrder('hierarchy', 'DESC')
            ->walk(array($this->_getResource(), 'updateRuleCustomerData'));
    }

    public function applyRule($id)
    {
        $rule = Mage::getModel('group_adherence/adherence')->load($id);
        Mage::getResourceModel('group_adherence/adherence')->updateRuleCustomerData($rule);

    }

    public function getMatchingCustomerIds()
    {
        if (is_null($this->_customerIds)) {
            $this->_customerIds = array();
            $this->setCollectedAttributes(array());

            $customerCollection = Mage::getModel('customer/customer')
                ->getCollection()
                ->addAttributeToSelect('*');

            if ($this->getWebsitesSerialized()) {
                $customerCollection->addAttributeToFilter('website_id', $this->getWebsitesSerialized());
            }

            if ($this->getGroupsSerialized()) {
                $customerCollection->addAttributeToFilter('group_id', $this->getGroupsSerialized());
            }

            $this->getConditions()->collectValidatedAttributes($customerCollection);

            Mage::getSingleton('core/resource_iterator')->walk(
                $customerCollection->getSelect(),
                array(array($this, 'callbackValidateCustomer')),
                array(
                    'attributes' => $this->getCollectedAttributes(),
                    'customer' => Mage::getModel('customer/customer'),
                )
            );
        }

        return $this->_customerIds;
    }

    public function callbackValidateCustomer($args)
    {
        $customer = clone $args['customer'];
        $customer->setData($args['row']);

        $this->_customerIds[$customer->getId()] = (int)$this->getConditions()->validate($customer);
    }

}
