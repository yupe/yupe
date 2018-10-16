<?php

class m161122_093736_add_store_layouts extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->addColumn('{{store_product}}', 'view', 'VARCHAR(100) DEFAULT NULL');
		$this->addColumn('{{store_producer}}', 'view', 'VARCHAR(100) DEFAULT NULL');
		$this->addColumn('{{store_category}}', 'view', 'VARCHAR(100) DEFAULT NULL');
	}

	public function safeDown()
	{
		$this->dropColumn('{{store_product}}', 'view');
		$this->dropColumn('{{store_producer}}', 'view');
		$this->dropColumn('{{store_category}}', 'view');
	}
}