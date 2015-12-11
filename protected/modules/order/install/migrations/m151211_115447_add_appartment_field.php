<?php

class m151211_115447_add_appartment_field extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->addColumn('{{store_order}}', 'apartment', 'VARCHAR(10)');
	}
}