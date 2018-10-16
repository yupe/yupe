<?php

class m140813_230000_store_producer_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{store_producer}}",
            [
                "id" => "pk",
                "name_short" => "varchar(150) not null",
                "name" => "varchar(250) not null",
                "slug" => "varchar(150) not null",
                "image" => "varchar(250) default null",
                "short_description" => "text",
                "description" => "text",
                "meta_title" => "varchar(250) default null",
                "meta_keywords" => "varchar(250) default null",
                "meta_description" => "varchar(250) default null",
                "status" => "integer not null default '1'",
                "order" => "integer not null default '0'",
            ],
            $this->getOptions()
        );

        $this->createIndex("ix_{{store_producer}}_slug", "{{store_producer}}", "slug", false);
    }

    public function safeDown()
    {
        $this->dropTable("{{store_producer}}");
    }
}
