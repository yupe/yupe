<?php

class m150211_105453_add_position_for_product_variant extends CDbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{store_product_variant}}', 'position', "integer not null default '1'");

         $result = Yii::app()->db->createCommand("select id FROM {{store_product_variant}}")->queryAll();
        if ($result) {
            foreach ($result as $item) {
                $query = "update {{store_product_variant}} set position = :id where id=:id";
                $command = Yii::app()->db->createCommand($query);
                $command->execute(array(
                        ':id' => $item['id']
                    )
                );
            }
        }

	}

	public function safeDown()
	{
        $this->dropColumn('{{store_product_variant}}', 'position');
	}
}