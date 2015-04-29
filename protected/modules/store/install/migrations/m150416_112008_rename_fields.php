<?php

class m150416_112008_rename_fields extends CDbMigration
{
	public function safeUp()
	{
        $this->renameColumn('{{store_product}}', 'alias', 'slug');

        $this->renameColumn('{{store_category}}', 'alias', 'slug');
	}
}