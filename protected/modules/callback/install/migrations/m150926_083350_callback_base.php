<?php

class m150926_083350_callback_base extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->createTable('{{callback}}', [
            'id' =>'pk',
            'name' => 'string',
            'phone' => 'string',
            'time' => 'string',
            'comment' => 'string',
            'status' => 'integer DEFAULT 0'
        ]);
	}

	public function safeDown()
	{
        $this->dropTable('{{callback}}');
	}
}