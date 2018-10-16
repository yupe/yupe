<?php

class m160914_134555_fix_menu_item_default_values extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->alterColumn('{{menu_menu_item}}', 'class', 'VARCHAR(150) DEFAULT NULL');
		$this->alterColumn('{{menu_menu_item}}', 'title_attr', 'VARCHAR(150) DEFAULT NULL');
		$this->alterColumn('{{menu_menu_item}}', 'before_link', 'VARCHAR(150) DEFAULT NULL');
		$this->alterColumn('{{menu_menu_item}}', 'after_link', 'VARCHAR(150) DEFAULT NULL');
		$this->alterColumn('{{menu_menu_item}}', 'target', 'VARCHAR(150) DEFAULT NULL');
		$this->alterColumn('{{menu_menu_item}}', 'rel', 'VARCHAR(150) DEFAULT NULL');
	}
}