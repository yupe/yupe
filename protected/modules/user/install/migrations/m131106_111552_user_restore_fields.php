<?php

class m131106_111552_user_restore_fields extends CDbMigration
{
    public function safeUp()
	{
        $this->addColumn('{{user_user}}', 'email_confirm', "boolean NOT NULL DEFAULT '0'");
        $this->addColumn('{{user_user}}', 'registration_date', 'datetime NOT NULL DEFAULT NOW()');
	}

	public function safeDown()
	{
        $this->dropColumn('{{user_user}}', 'email_confirm');
        $this->dropColumn('{{user_user}}', 'registration_date');
	}
}