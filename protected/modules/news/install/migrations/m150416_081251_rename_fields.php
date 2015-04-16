<?php

class m150416_081251_rename_fields extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->renameColumn('{{news_news}}', 'creation_date', 'create_time');
        $this->renameColumn('{{news_news}}', 'change_date', 'update_time');
        $this->renameColumn('{{news_news}}', 'alias', 'slug');
	}
}