<?php

class m140812_170000_store_attribute_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{store_attribute}}",
            [
                "id" => "pk",
                "group_id" => "integer null",
                "name" => "varchar(250) not null",
                "title" => "varchar(250) default null",
                "type" => "tinyint(4) null default null",
                "unit" => "varchar(30) null",
                "required" => "boolean not null default '0'",
            ],
            $this->getOptions()
        );

        //index
        $this->createIndex("ux_{{store_attribute}}_name_group", "{{store_attribute}}", "name, group_id", true);
        $this->createIndex("ix_{{store_attribute}}_title", "{{store_attribute}}", "title", false);

        //fk
        $this->addForeignKey("fk_{{store_attribute}}_group", "{{store_attribute}}", "group_id", "{{store_attribute_group}}", "id", "CASCADE", "CASCADE");

    }

    public function safeDown()
    {
        $this->dropTable("{{store_attribute}}");
    }
}
