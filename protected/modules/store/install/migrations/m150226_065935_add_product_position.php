<?php

class m150226_065935_add_product_position extends CDbMigration
{
    public function safeUp()
	{
        $this->addColumn('{{store_product}}', 'position', "integer not null default '1'");

        Yii::app()->getDb()->createCommand("UPDATE {{store_product}} SET position = id")->execute();
	}

	public function safeDown()
	{
        $this->dropColumn('{{store_product}}', 'position');
	}
}
