<?php

class m150907_084604_new_attributes extends \yupe\components\DbMigration
{
	public function safeUp()
	{
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

		//перенести аттрибуты
		$attributes = Yii::app()->getDb()->createCommand('SELECT * FROM {{store_product_attribute_eav}}')->queryAll();

		$modelsAttr = [];

		foreach($attributes as $attribute) {

			$product = Product::model()->findByPk($attribute['product_id']);

			if(null === $product) {
				continue;
			}

			if(!isset($modelsAttr[$attribute['attribute']])) {
				$model = Attribute::model()->find('name = :name', [':name' => $attribute['attribute']]);
				if(null === $model) {
					continue;
				}
				$modelsAttr[$attribute['attribute']] = $model;
			}

			$value = new AttributeValue();
			$value->store($modelsAttr[$attribute['attribute']]->id, $attribute['value'], $product);
		}

		$this->dropTable('{{store_product_attribute_eav}}');
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