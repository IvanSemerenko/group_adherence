<?php

class Group_Adherence_Model_Adminhtml_System_Config_Backend_Cron_Cron
    extends Mage_Core_Model_Config_Data
{
    const CRON_STRING_PATH  = 'crontab/jobs/group_adherence/schedule/cron_expr';
    const CRON_MODEL_PATH   = 'crontab/jobs/group_adherence/run/model';

    protected function _afterSave()
    {
        $enabled    = $this->getData('groups/groupadherence_schedule/fields/enabled/value');
        $time       = $this->getData('groups/groupadherence_schedule/fields/groupadherence_start_time/value');
        $frequncy   = $this->getData('groups/groupadherence_schedule/fields/groupadherence_frequency/value');

        $frequencyWeekly    = Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency::CRON_WEEKLY;
        $frequencyMonthly   = Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency::CRON_MONTHLY;

        if ($enabled) {
            $cronExprArray = array(
                intval($time[1]),
                intval($time[0]),
                ($frequncy == $frequencyMonthly) ? '1' : '*',
                '*',
                ($frequncy == $frequencyWeekly) ? '1' : '*',
            );
            $cronExprString = join(' ', $cronExprArray);
        }
        else {
            $cronExprString = '';
        }

        try {
            Mage::getModel('core/config_data')
                ->load(self::CRON_STRING_PATH, 'path')
                ->setValue($cronExprString)
                ->setPath(self::CRON_STRING_PATH)
                ->save();

            Mage::getModel('core/config_data')
                ->load(self::CRON_MODEL_PATH, 'path')
                ->setValue((string) Mage::getConfig()->getNode(self::CRON_MODEL_PATH))
                ->setPath(self::CRON_MODEL_PATH)
                ->save();
        }
        catch (Exception $e) {
            Mage::throwException(Mage::helper('adminhtml')->__('Unable to save the cron expression.'));
        }
    }
}
