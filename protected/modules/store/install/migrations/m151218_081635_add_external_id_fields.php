<?php

class m151218_081635_add_external_id_fields extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->addColumn('{{store_category}}', 'external_id', 'integer default null');
		$this->addColumn('{{store_product}}', 'external_id', 'integer default null');
	}

	public function safeDown()
	{
		$this->dropColumn('{{store_category}}', 'external_id');
		$this->dropColumn('{{store_product}}', 'external_id');
	}
}