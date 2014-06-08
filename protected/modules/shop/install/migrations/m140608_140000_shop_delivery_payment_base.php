<?php

class m140608_140000_shop_delivery_payment_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_delivery_payment}}', array(
                'delivery_id' => 'integer not null',
                'payment_id' => 'integer not null',
                'PRIMARY KEY (`delivery_id`, `payment_id`)'
            ), 'ENGINE=MyISAM DEFAULT CHARSET=utf8'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_delivery_payment}}');
    }
}