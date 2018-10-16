<?php

class m160215_110749_add_image_groups_table extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->createTable('{{store_product_image_group}}', [
			'id' => 'pk',
			'name' => 'string',
		], $this->getOptions());

		$this->addColumn('{{store_product_image}}', 'group_id', 'integer');

		$this->addForeignKey('fk_{{store_product_image}}_group',
			'{{store_product_image}}', 'group_id',
			'{{store_product_image_group}}', 'id',
			'NO ACTION', 'SET NULL'
		);
	}

	public function safeDown()
	{
		$this->dropForeignKey('fk_{{store_product_image}}_group', '{{store_product_image}}');

		$this->dropColumn('{{store_product_image}}', 'group_id');

		$this->dropTable('{{store_product_image_group}}');
	}
}