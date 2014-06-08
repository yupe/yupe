<?php

class m140608_120000_shop_payment_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_payment}}', array(
                'id' => 'pk',
                'module' => 'varchar(100) not null',
                'name' => 'varchar(255) not null',
                'description' => 'text null',
                'settings' => 'text null',
                'currency_id' => "integer null",
                'position' => "integer not null default '1'",
                'status' => "tinyint not null default '1'",
            ), 'ENGINE=MyISAM DEFAULT CHARSET=utf8'
        );
        $this->createIndex("idx_{{shop_payment}}_position", '{{shop_payment}}', "position");
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_payment}}');
    }
}