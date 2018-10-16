<?php

class m150415_151804_rename_fields extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->renameColumn('{{comment_comment}}', 'creation_date', 'create_time');
	}
}