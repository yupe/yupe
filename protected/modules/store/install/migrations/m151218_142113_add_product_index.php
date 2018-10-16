<?php

class m151218_142113_add_product_index extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->createIndex('ix_{{store_product}}_sku', '{{store_product}}', 'sku');
		$this->createIndex('ix_{{store_product}}_name', '{{store_product}}', 'name');
	}

	public function safeDown()
	{
		$this->dropIndex('ix_{{store_product}}_sku', '{{store_product}}');
		$this->dropIndex('ix_{{store_product}}_name', '{{store_product}}');
	}
}