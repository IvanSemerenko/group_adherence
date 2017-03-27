<?php

/**
 * @author Ivan Semerenko <Semerenko888@yandex.ru>
 * @copyright Copyright (c) 2017, Ivan Semerenko
 */

class SVI_GroupAdherence_Model_Cron
{
    public function applyAll()
    {
        Mage::getModel('svi_groupAdherence/adherence')->applyAll();
    }
}