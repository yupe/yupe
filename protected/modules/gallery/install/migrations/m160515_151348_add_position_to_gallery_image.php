<?php

class m160515_151348_add_position_to_gallery_image extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->addColumn('{{gallery_image_to_gallery}}', 'position', 'integer NOT NULL DEFAULT 1');

		Yii::app()->getDb()->createCommand('UPDATE {{gallery_image_to_gallery}} SET `position` = `id`')->query();
	}

	public function safeDown()
	{
		$this->dropColumn('{{gallery_image_to_gallery}}', 'position');
	}
}