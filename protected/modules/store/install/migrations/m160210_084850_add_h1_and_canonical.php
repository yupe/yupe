<?php

class m160210_084850_add_h1_and_canonical extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->addColumn('{{store_product}}', 'title', 'string');
		$this->addColumn('{{store_product}}', 'meta_canonical', 'string');

		$this->addColumn('{{store_category}}', 'title', 'string');
		$this->addColumn('{{store_category}}', 'meta_canonical', 'string');
	}

	public function safeDown()
	{
		$this->dropColumn('{{store_product}}', 'title');
		$this->dropColumn('{{store_product}}', 'meta_canonical');

		$this->dropColumn('{{store_category}}', 'title');
		$this->dropColumn('{{store_category}}', 'meta_canonical');
	}
}