<?php

class m160621_075232_add_date_to_callback extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{callback}}', 'create_time', 'DATETIME');
	}

	public function safeDown()
	{
        $this->dropColumn('{{callback}}', 'create_time');
	}
}