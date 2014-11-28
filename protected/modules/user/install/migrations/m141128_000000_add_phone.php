<?php

class m141128_000000_add_phone extends CDbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{user_user}}', 'phone', 'varchar(50) DEFAULT NULL');
        $this->addColumn('{{user_user}}', 'phone_confirm', 'boolean NOT NULL DEFAULT "0"');
        $this->createIndex("ix_{{user_user}}_phone", '{{user_user}}', "phone", false);
        $this->createIndex("ix_{{user_user}}_phone_confirm", '{{user_user}}', "phone_confirm", false);
	}

	public function safeDown()
	{
        $this->dropColumn('{{user_user}}', 'phone');
        $this->dropColumn('{{user_user}}', 'phone_confirm');
	}
}
