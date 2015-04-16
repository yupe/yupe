<?php

class m150416_125517_rename_fields extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->renameColumn('{{yupe_settings}}', 'creation_date', 'create_time');
        $this->renameColumn('{{yupe_settings}}', 'change_date', 'update_time');
	}
}