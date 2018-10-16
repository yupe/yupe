<?php

class m161015_121915_change_product_external_id_type extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->alterColumn('{{store_product}}', 'external_id', 'VARCHAR(100) DEFAULT NULL');
		$this->alterColumn('{{store_category}}', 'external_id', 'VARCHAR(100) DEFAULT NULL');
	}

	public function safeDown()
	{
		$this->alterColumn('{{store_product}}', 'external_id', 'integer default null');
		$this->alterColumn('{{store_category}}', 'external_id', 'integer default null');
	}
}