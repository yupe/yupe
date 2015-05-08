<?php

class m150416_100212_rename_fields extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->renameColumn('{{store_order}}', 'payment_date', 'payment_time');
	}
}