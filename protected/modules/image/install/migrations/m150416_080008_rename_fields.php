<?php

class m150416_080008_rename_fields extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->renameColumn('{{image_image}}', 'creation_date', 'create_time');
	}
}