<?php

class m140813_210000_store_type_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{store_type}}",
            [
                "id" => "pk",
                "name" => "varchar(255) not null",
                "main_category_id" => "int(11) null default null",
                "categories" => "text null default null",
            ],
            $this->getOptions()
        );

        $this->createIndex("ux_{{store_type}}_name", "{{store_type}}", "name", true);

        $this->addForeignKey("fk_{{store_type}}_main_category", "{{store_type}}", "main_category_id", "{{store_category}}", "id", "SET NULL", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{store_type}}");
    }
}
