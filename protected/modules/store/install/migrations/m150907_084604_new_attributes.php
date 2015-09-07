<?php

class m150907_084604_new_attributes extends \yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->createTable('{{store_product_attribute_value}}',[
			'id' => 'pk',
			'product_id'   => 'INTEGER NOT NULL',
			'attribute_id' => 'INTEGER NOT NULL',
			'int_value'    => 'INTEGER',
			'str_value'    => 'VARCHAR(250)',
			'text_value'   => 'TEXT'
		],  $this->getOptions());

		//fk
		$this->addForeignKey('{{fk_product_attribute_product}}', '{{store_product_attribute_value}}', 'product_id','{{store_product}}', 'id','CASCADE');
		$this->addForeignKey('{{fk_product_attribute_attribute}}', '{{store_product_attribute_value}}', 'attribute_id','{{store_attribute}}', 'id','CASCADE');
	}

	public function safeDown()
	{
		$this->dropTable('{{store_product_attribute}}');
	}
}