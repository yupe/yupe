<?php

class m151218_082939_add_external_id_ix extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->createIndex('{{store_category_external_id_ix}}', '{{store_category}}', 'external_id');
		$this->createIndex('{{store_product_external_id_ix}}', '{{store_product}}', 'external_id');
	}
}