<?php

class m140607_200000_shop_delivery_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_delivery}}', array(
                'id' => 'pk',
                'name' => 'varchar(255) not null',
                'description' => 'text null',
                'price' => "float(10, 2) not null default '0'",
                'free_from' => "float(10, 2) null",
                'available_from' => "float(10, 2) null",
                'position' => "integer not null default '1'",
                'status' => "tinyint not null default '1'",
                'separate_payment' => "tinyint null default '0'",
            ), 'ENGINE=MyISAM DEFAULT CHARSET=utf8'
        );
        $this->createIndex("idx_{{shop_delivery}}_position", '{{shop_delivery}}', "position");
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_delivery}}');
    }
}