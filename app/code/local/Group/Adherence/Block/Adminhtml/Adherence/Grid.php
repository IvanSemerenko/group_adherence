<?php

class Group_Adherence_Block_Adminhtml_Adherence_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('rule_block');
        $this->setDefaultSort('rule_id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('group_adherence/adherence')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Block_Collection */
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('rule_id', array(
            'header'    => Mage::helper('adherence')->__('ID'),
            'align'     => 'left',
            'index'     => 'rule_id',
            'type'      => 'currency',
            'currency'  => 'base_currency_code',
        ));

        $this->addColumn('rule_name', array(
            'header'    => Mage::helper('adherence')->__('Rule`s name'),
            'align'     => 'left',
            'index'     => 'rule_name',
        ));

        $groups = Mage::getResourceModel('customer/group_collection')
            ->load()
            ->toOptionHash();

        $this->addColumn('group_id', array(
            'header'    => Mage::helper('adherence')->__('Group'),
            'align'     => 'left',
            'type'      => 'options',
            'index'     => 'group_id',
            'options'   => $groups
        ));

        $this->addColumn('hierarchy', array(
            'header'    => Mage::helper('adherence')->__('Hierarchy'),
            'align'     => 'left',
            'index'     => 'hierarchy',
            'type'      => 'currency',
            'currency'  => 'base_currency_code',
        ));

        $this->addColumn('rule_status', array(
            'header' => Mage::helper('adherence')->__('Status'),
            'align' => 'left',
            'type' => 'options',
            'options' => Mage::getModel('group_adherence/source_status')->toArray(),
            'index' => 'rule_status'
        ));

        return parent::_prepareColumns();
    }

    public function _prepareMassaction()
    {
        $this->setMassactionIdField('rule_id');
        $this->getMassactionBlock()->setIdFieldName('rule_id');
        $this->getMassactionBlock()
            ->additem('delete',
                array(
                    'label' => Mage::helper('adherence')->__('Delete'),
                    'url' => $this->getUrl('*/*/massDelete'),
                    'confirm' => Mage::helper('adherence')->__('Are you sure?')
                )
            )->additem('status',
                array(
                    'label' => Mage::helper('adherence')->__('Update Status'),
                    'url' => $this->getUrl('*/*/massStatus'),
                    'additional' => array(
                        'block_status' => array(
                            'name'      => 'rule_status',
                            'type'      => 'select',
                            'class'     => 'requird-entry',
                            'label'     => Mage::helper('adherence')->__('Status'),
                            'values'    => Mage::getModel('group_adherence/source_status')->toArray()
                        )
                    )
                )
            );
        return $this;
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('rule_id' => $row->getId()));
    }

}
