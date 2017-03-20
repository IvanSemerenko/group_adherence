<?php

class Group_Adherence_Adminhtml_AdherenceController extends Mage_Adminhtml_Controller_Action
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
        Mage::register('adherence_rule', Mage::getModel('group_adherence/adherence')->load($id));

        $this->loadLayout();
        $this->_addLeft($this->getLayout()->createBlock('adherence/adminhtml_adherence_edit_tabs'));
        $this->_addContent($this->getLayout()->createBlock('adherence/adminhtml_adherence_edit'));
        $this->renderLayout();
    }

    public function saveAction()
    {
        try{
            $id = $this->getRequest()->getParam('rule_id');
            $rule = Mage::getModel('group_adherence/adherence')->load($id);

            $data = $this->getRequest()->getParams();

            if(isset($data['rule'])) {
                $data['conditions'] = $data['rule']['conditions'];
                unset($data['rule']);
            }

            $rule->loadPost($data)->save();

            if (!$rule->getId()) {
                Mage::getSingleton('adminhtml/session')->addError('Cannot save the Rule!');
            }

        } catch(Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setBlockObject($rule->getdata());
        }

        Mage::getSingleton('adminhtml/session')->addSuccess('Rule was save successfully');

        $this->_redirect('*/*/'.$this->getRequest()->getParam('back','index'),array('rule_id'=>$rule->getId()));
    }

    public function deleteAction()
    {
        $block = Mage::getModel('group_adherence/adherence')
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
            $rules = mage::getModel('group_adherence/adherence')
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
            $rules = mage::getModel('group_adherence/adherence')
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