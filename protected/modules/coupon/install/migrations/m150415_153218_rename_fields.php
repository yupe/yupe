<?php

class m150415_153218_rename_fields extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->renameColumn('{{store_coupon}}', 'date_start', 'start_time');
        $this->renameColumn('{{store_coupon}}', 'date_end', 'end_time');
	}
}