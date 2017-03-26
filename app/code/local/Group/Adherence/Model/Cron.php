<?php

/**
 * @author Ivan Semerenko <Semerenko888@yandex.ru>
 * @copyright Copyright (c) 2017, Ivan Semerenko
 */

class Group_Adherence_Model_Cron
{
    public function applyAll()
    {
        Mage::getModel('group_adherence/adherence')->applyAll();
    }
}