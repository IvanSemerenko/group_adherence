<?php

/**
 * @author Ivan Semerenko <Semerenko888@yandex.ru>
 * @copyright Copyright (c) 2017, Ivan Semerenko
 */

class Group_Adherence_Block_Adminhtml_Adherence_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('rule_form');
        $this->setTitle(Mage::helper('adherence')->__('Rule Information'));
    }

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save',array('rule_id'=>$this->getRequest()->getParam('rule_id'))),
                'method' => 'post',
            )
        );

        $form->setHtmlIdPrefix('rule_');
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
