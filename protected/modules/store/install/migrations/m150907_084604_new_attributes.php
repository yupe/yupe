<?php

class m150907_084604_new_attributes extends \yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->dropTable('{{store_product_attribute_eav}}');

		$this->createTable('{{store_product_attribute_value}}',[
			'id' => 'pk',
			'product_id'   => 'INTEGER NOT NULL',
			'attribute_id' => 'INTEGER NOT NULL',
			'number_value'    => 'REAL',
			'string_value'    => 'VARCHAR(250)',
			'text_value'   => 'TEXT',
			'option_value' => 'INTEGER',
			'create_time'  => 'DATETIME'
		],  $this->getOptions());

		//fk
		$this->addForeignKey('{{fk_product_attribute_product}}', '{{store_product_attribute_value}}', 'product_id','{{store_product}}', 'id','CASCADE');
		$this->addForeignKey('{{fk_product_attribute_attribute}}', '{{store_product_attribute_value}}', 'attribute_id','{{store_attribute}}', 'id','CASCADE');
		$this->addForeignKey('{{fk_product_attribute_option}}', '{{store_product_attribute_value}}','option_value', '{{store_attribute_option}}', 'id', 'CASCADE');

		//ix
		$this->createIndex('{{ix_product_attribute_number_value}}', '{{store_product_attribute_value}}', 'number_value');
		$this->createIndex('{{ix_product_attribute_string_value}}', '{{store_product_attribute_value}}', 'string_value');

	}

	public function safeDown()
	{
		$this->dropTable('{{store_product_attribute_value}}');

		$this->createTable(
			"{{store_product_attribute_eav}}",
			[
				"product_id" => "integer not null",
				"attribute" => "varchar(250) not null",
				"value" => "text",
			],
			$this->getOptions()
		);

		$this->createIndex("ix_{{store_product_attribute_eav}}_product_id", "{{store_product_attribute_eav}}", "product_id", false);
		$this->createIndex("ix_{{store_product_attribute_eav}}_attribute", "{{store_product_attribute_eav}}", "attribute", false);

		//fk
		$this->addForeignKey("fk_{{store_product_attribute_eav}}_product", "{{store_product_attribute_eav}}", "product_id", "{{store_product}}", "id", "CASCADE", "CASCADE");
		$this->addForeignKey("fk_{{store_product_attribute_eav}}_attribute", "{{store_product_attribute_eav}}", "attribute", "{{store_attribute}}", "name", "CASCADE", "CASCADE");
	}
}