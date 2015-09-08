<?php

class m150908_075729_rename_status extends EDbMigration
{
	public function safeUp()
	{
        Yii::app()->getDb()->createCommand('UPDATE {{store_order_status}} SET name = "Подтвержден" WHERE id=2')->execute();
	}
}