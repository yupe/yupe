<?php

class m160227_114934_rename_producer_order_column extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->renameColumn('{{store_producer}}', 'order', 'sort');
		Yii::app()->getDb()->createCommand()->update('{{store_producer}}', ['sort' => new CDbExpression('id')]);
	}

	public function safeDown()
	{
		$this->renameColumn('{{store_producer}}', 'sort', 'order');
	}
}