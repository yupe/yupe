<?php

class m160204_195213_change_settings_type extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->alterColumn('{{yupe_settings}}', 'param_value', 'varchar(500) NOT NULL');
	}

	public function safeDown()
	{
		$this->alterColumn('{{yupe_settings}}', 'param_value', 'varchar(255) NOT NULL');
	}
}