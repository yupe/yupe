<?php
Yii::import('application.modules.user.models.*');

class m131106_111552_user_restore_fields extends CDbMigration
{
    public function safeUp()
    {
        Yii::app()->cache->flush();
        $this->addColumn('{{user_user}}', 'email_confirm', "boolean NOT NULL DEFAULT '0'");
        if (!User::model()->hasAttribute('registration_date')) {
            $this->addColumn('{{user_user}}', 'registration_date', 'datetime');
        }
    }

    public function safeDown()
    {
        $this->dropColumn('{{user_user}}', 'email_confirm');
        if (User::model()->hasAttribute('registration_date')) {
            $this->dropColumn('{{user_user}}', 'registration_date');
        }
    }
}
