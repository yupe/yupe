<?php

class m150416_074146_rename_fields extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->renameColumn('{{gallery_image_to_gallery}}', 'creation_date', 'create_time');
	}
}