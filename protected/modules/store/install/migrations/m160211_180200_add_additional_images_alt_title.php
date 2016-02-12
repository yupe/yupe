<?php

class m160211_180200_add_additional_images_alt_title extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->addColumn('{{store_product_image}}', 'alt', 'string');
	}

	public function safeDown()
	{
		$this->dropColumn('{{store_product_image}}', 'alt');
	}
}