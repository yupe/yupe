<?php

class m140813_200000_store_category_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{store_category}}",
            [
                "id" => "pk",
                "parent_id" => "integer default null",
                "alias" => "varchar(150) not null",
                "name" => "varchar(250) not null",
                "image" => "varchar(250) default null",
                "short_description" => "text",
                "description" => "text",
                "meta_title" => "varchar(250) default null",
                "meta_description" => "varchar(250) default null",
                "meta_keywords" => "varchar(250) default null",
                "status" => "boolean not null default '1'",
            ],
            $this->getOptions()
        );

        //ix
        $this->createIndex("ux_{{store_category}}_alias", "{{store_category}}", "alias", true);
        $this->createIndex("ix_{{store_category}}_parent_id", "{{store_category}}", "parent_id", false);
        $this->createIndex("ix_{{store_category}}_status", "{{store_category}}", "status", false);

        //fk
        $this->addForeignKey("fk_{{store_category}}_parent", "{{store_category}}", "parent_id", "{{store_category}}", "id", "CASCADE", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{store_category}}");
    }
}
