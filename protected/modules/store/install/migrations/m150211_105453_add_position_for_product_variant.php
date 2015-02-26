<?php

class m150211_105453_add_position_for_product_variant extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{store_product_variant}}', 'position', "integer not null default '1'");

        Yii::app()->getDb()->createCommand("UPDATE {{store_product_variant}} SET position = id")->execute();
    }

    public function safeDown()
    {
        $this->dropColumn('{{store_product_variant}}', 'position');
    }
}
