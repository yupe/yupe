<?php

class m160602_091243_add_position_product_index extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->createIndex('ix_{{store_product}}_position', '{{store_product}}', 'position');
	}

	public function safeDown()
	{
		$this->dropIndex('ix_{{store_product}}_position', '{{store_product}}');
	}
}