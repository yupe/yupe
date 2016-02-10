<?php

class m160210_131541_add_main_image_alt_title extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->addColumn('{{store_product}}', 'image_alt', 'string');
		$this->addColumn('{{store_product}}', 'image_title', 'string');

		$this->addColumn('{{store_category}}', 'image_alt', 'string');
		$this->addColumn('{{store_category}}', 'image_title', 'string');
	}

	public function safeDown()
	{
		$this->dropColumn('{{store_product}}', 'image_alt');
		$this->dropColumn('{{store_product}}', 'image_title');

		$this->dropColumn('{{store_category}}', 'image_alt');
		$this->dropColumn('{{store_category}}', 'image_title');
	}
}