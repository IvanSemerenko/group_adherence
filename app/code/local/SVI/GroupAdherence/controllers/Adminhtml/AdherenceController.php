<?php

/**
 * @author Ivan Semerenko <Semerenko888@yandex.ru>
 * @copyright Copyright (c) 2017, Ivan Semerenko
 */

class SVI_GroupAdherence_Adminhtml_AdherenceController
    extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('adherence/adminhtml_adherence'));
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('rule_id');
        Mage::register('adherence_rule', Mage::getModel('svi_groupAdherence/adherence')->load($id));

        $this->loadLayout();
        $this->_addLeft($this->getLayout()->createBlock('adherence/adminhtml_adherence_edit_tabs'));
        $this->_addContent($this->getLayout()->createBlock('adherence/adminhtml_adherence_edit'));
        $this->renderLayout();
    }

    public function saveAction()
    {
        try{
            $id = $this->getRequest()->getParam('rule_id');
            $rule = Mage::getModel('svi_groupAdherence/adherence')->load($id);

            $data = $this->getRequest()->getParams();

            if(isset($data['rule'])) {
                $data['conditions'] = $data['rule']['conditions'];
                unset($data['rule']);
            }

            $autoApply = false;
            if (!empty($data['auto_apply'])) {
                $autoApply = true;
                unset($data['auto_apply']);
            }

            if(!isset($data['groups_serialized'])) {
                $data['groups_serialized'] = array();
            }

            if(!isset($data['websites_serialized'])) {
                $data['websites_serialized'] = array();
            }

            $rule->loadPost($data)->save();

            if (!$rule->getId()) {
                Mage::getSingleton('adminhtml/session')->addError('Cannot save the Rule!');
            }

            if ($autoApply) {
                $this->getRequest()->setParam('rule_id', $rule->getId());
                $this->_forward('applyRules');
            }
        } catch(Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setBlockObject($rule->getdata());
        }

        Mage::getSingleton('adminhtml/session')
            ->addSuccess(Mage::helper('adherence')->__('Rule was save successfully'));

        $this->_redirect('*/*/'.$this->getRequest()->getParam('back','index'),array('rule_id'=>$rule->getId()));
    }

    public function applyRulesAction()
    {
        $errorMessage = Mage::helper('adherence')->__('Unable to apply rules.');
        try {
            $id = $this->getRequest()->getParam('rule_id');

            if($id) {
                Mage::getModel('svi_groupAdherence/adherence')->applyRule($id);
            }else{
                Mage::getModel('svi_groupAdherence/adherence')->applyAll();
            }
            Mage::getSingleton('adminhtml/session')
                ->addSuccess(Mage::helper('adherence')->__('The rules have been applied.'));
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('adminhtml/session')
                ->addError($errorMessage . ' ' . $e->getMessage());
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')
                ->addError($errorMessage);
            Mage::logException($e);
        }
        $this->_redirect('*/*');
    }

    public function deleteAction()
    {
        $block = Mage::getModel('svi_groupAdherence/adherence')
            ->setId($this->getRequest()->getParam('rule_id'))
            ->delete();
        if ($block->getId()) {
            Mage::getSingleton('adminhtml/session')->addSuccess('Rule was delete successfully');
        }

        $this->_redirect('*/*/');
    }

    public function massStatusAction()
    {
        $statutes = $this->getRequest()->getParams();

        try {
            $rules = mage::getModel('svi_groupAdherence/adherence')
                ->getCollection()
                ->addFieldToFilter('rule_id',array('in' => $statutes['massaction']));

            foreach($rules as $rule) {
                $rule->setRuleStatus($statutes['rule_status'])->save();
            }
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return $this->_redirect('*/*/');
        }

        Mage::getSingleton('adminhtml/session')->addSuccess('Rules were successfully update');

        return $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $rule_ids = $this->getRequest()->getParams();

        try {
            $rules = mage::getModel('svi_groupAdherence/adherence')
                ->getCollection()
                ->addFieldToFilter('rule_id',array('in' => $rule_ids['massaction']));
            foreach($rules as $rule) {
                $rule->delete();
            }
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return $this->_redirect('*/*/');
        }

        Mage::getSingleton('adminhtml/session')->addSuccess('Rules were successfully delete');

        return $this->_redirect('*/*/');
    }
}