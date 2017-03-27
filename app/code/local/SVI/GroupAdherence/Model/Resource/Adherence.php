<?php

/**
 * @author Ivan Semerenko <Semerenko888@yandex.ru>
 * @copyright Copyright (c) 2017, Ivan Semerenko
 */

class SVI_GroupAdherence_Model_Resource_Adherence
    extends Mage_Rule_Model_Resource_Abstract
{
    public function _construct()
    {
        $this->_init('svi_groupAdherence/adherence', 'rule_id');
    }

    public function updateRuleCustomerData(SVI_GroupAdherence_Model_Adherence $rule)
    {
        if (!$rule->getRuleStatus()) {
            return $this;
        }

        try {
            $this->insertRuleData($rule);
        } catch (Exception $e) {
            throw $e;
        }

        return $this;
    }

    public function insertRuleData(SVI_GroupAdherence_Model_Adherence $rule)
    {
        $customerIds = $rule->getMatchingCustomerIds();

       if(!empty($customerIds)) {
           foreach ($customerIds as $customerId => $validationByWebsite) {
               if (!$validationByWebsite) {
                   continue;
               }

               $customerDataId[] = $customerId;

               if (count($customerDataId) == 1000) {
                   $customers =  Mage::getModel('customer/customer')
                       ->getCollection()
                       ->addFieldToFilter('entity_id', array('in' => $customerDataId));

                   foreach($customers as $customer) {
                       $customer->setGroupId($rule->groupId)->save();
                   }

                   $customerDataId = array();
               }
           }
       }

        if (!empty($customerDataId)) {
            $customers =  Mage::getModel('customer/customer')
                ->getCollection()
                ->addFieldToFilter('entity_id', array('in' => $customerDataId));

            foreach($customers as $customer) {
                $customer->setGroupId($rule->groupId)->save();
            }
        }
    }
}