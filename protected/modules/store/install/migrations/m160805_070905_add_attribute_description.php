<?php

class m160805_070905_add_attribute_description extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->addColumn('{{store_attribute}}', 'description', 'text null');
	}

	public function safeDown()
	{
		$this->dropColumn('{{store_attribute}}', 'description');
	}
}