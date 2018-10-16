<?php

class m161122_090922_add_sort_product_position extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->addColumn('{{store_product_link}}', 'position', 'INTEGER NOT NULL DEFAULT 1');

		Yii::app()->getDb()->createCommand('UPDATE {{store_product_link}} SET position=id')->execute();
	}

	public function safeDown()
	{
		$this->dropColumn('{{store_product_link}}', 'position');
	}
}