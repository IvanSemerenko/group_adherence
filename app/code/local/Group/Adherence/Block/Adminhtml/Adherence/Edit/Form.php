<?php

class Group_Adherence_Block_Adminhtml_Adherence_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('rule_form');
        $this->setTitle(Mage::helper('adherence')->__('Rule Information'));
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('adherence_rule');
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save',array('rule_id'=>$this->getRequest()->getParam('rule_id'))),
                'method' => 'post',
            )
        );

        $form->setHtmlIdPrefix('rule_');

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
