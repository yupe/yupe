<?php

class m151209_185124_split_address extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->renameColumn('{{store_order}}', 'address', 'street');

		$this->addColumn('{{store_order}}', 'zipcode', 'VARCHAR(30)');
		$this->addColumn('{{store_order}}', 'country', 'VARCHAR(150)');
		$this->addColumn('{{store_order}}', 'city', 'string');
		$this->addColumn('{{store_order}}', 'house', 'VARCHAR(50)');
	}
}