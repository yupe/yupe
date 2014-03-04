<?php

class m140303_150000_shop_product_image_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_product_image}}', array(
                'id' => 'pk',
                'product_id' => 'integer not null',
                'name' => "varchar(250) not null",
                'title' => "varchar(250) null",
                'is_main' => "boolean not null default '0'",
            ), 'ENGINE=MyISAM DEFAULT CHARSET=utf8'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_product_image}}');
    }
}