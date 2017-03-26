<?php

class Group_Adherence_Model_Cron
{
    public function applyAll()
    {
        Mage::getModel('group_adherence/adherence')->applyAll();
    }
}