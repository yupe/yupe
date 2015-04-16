<?php

class m150415_121606_rename_fields extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->renameColumn('{{catalog_good}}', 'alias', 'slug');
	}
}