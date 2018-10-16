<?php

class m160309_091039_add_attributes_sort_and_search_fields extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->addColumn('{{store_attribute}}', 'sort', 'INTEGER NOT NULL DEFAULT 0');
		Yii::app()->getDb()->createCommand()->update('{{store_attribute}}', ['sort' => new CDbExpression('id')]);
		$this->addColumn('{{store_attribute}}', 'is_filter', 'SMALLINT NOT NULL DEFAULT 1');
	}

	public function safeDown()
	{
		$this->dropColumn('{{store_attribute}}', 'sort');
		$this->dropColumn('{{store_attribute}}', 'is_filter');
	}
}