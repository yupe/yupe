<?php

class m150312_151049_change_body_type extends CDbMigration
{

	public function safeUp()
	{
        $this->alterColumn('{{page_page}}', 'body', 'MEDIUMTEXT NOT NULL');
	}

	public function safeDown()
	{
        $this->alterColumn('{{page_page}}', 'body', 'TEXT NOT NULL');
	}
}