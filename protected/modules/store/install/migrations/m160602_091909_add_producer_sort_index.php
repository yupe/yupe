<?php

class m160602_091909_add_producer_sort_index extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->createIndex('ix_{{store_producer}}_sort', '{{store_producer}}', 'sort');
	}

	public function safeDown()
	{
		$this->dropIndex('ix_{{store_producer}}_sort', '{{store_producer}}');
	}
}