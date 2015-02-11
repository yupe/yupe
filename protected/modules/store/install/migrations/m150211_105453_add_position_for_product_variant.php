<?php

class m150211_105453_add_position_for_product_variant extends CDbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{store_product_variant}}', 'position', "integer not null default '1'");

        $models = ProductVariant::model()->findAll();

        if ($models) {
            foreach ($models as $item) {
                $item->position = (int)$item->id;
                $item->update('position');
            }
        }
	}

	public function safeDown()
	{
        $this->dropColumn('{{store_product_variant}}', 'position');
	}
}
