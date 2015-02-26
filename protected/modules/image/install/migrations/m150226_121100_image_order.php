<?php

class m150226_121100_image_order extends CDbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{image_image}}', 'sort', "integer NOT NULL DEFAULT '1'");

        Yii::app()->getDb()->createCommand("UPDATE {{image_image}} SET sort = id")->execute();
	}

	public function safeDown()
	{
        $this->dropColumn('{{image_image}}', 'sort');
	}
}