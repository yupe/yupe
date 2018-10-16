<?php

class m151223_140722_drop_product_type_categories extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->dropForeignKey('fk_{{store_type}}_main_category', '{{store_type}}');
        $this->dropColumn('{{store_type}}', 'main_category_id');
		$this->dropColumn('{{store_type}}', 'categories');
	}

	public function safeDown()
	{
		$this->addColumn('{{store_type}}', 'main_category_id', 'int(11) null default null');
		$this->addColumn('{{store_type}}', 'categories', 'text null default null');
	}
}