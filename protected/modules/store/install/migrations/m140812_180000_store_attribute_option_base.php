<?php

class m140812_180000_store_attribute_option_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{store_attribute_option}}",
            [
                "id" => "pk",
                "attribute_id" => "int(11) null default null",
                "position" => "tinyint(4) null default null",
                "value" => "varchar(255) null default ''",
            ],
            $this->getOptions()
        );

        //ix
        $this->createIndex("ix_{{store_attribute_option}}_attribute_id", "{{store_attribute_option}}", "attribute_id", false);
        $this->createIndex("ix_{{store_attribute_option}}_position", "{{store_attribute_option}}", "position", false);

        //fk
        $this->addForeignKey("fk_{{store_attribute_option}}_attribute", "{{store_attribute_option}}", "attribute_id", "{{store_attribute}}", "id", "CASCADE", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{store_attribute_option}}");
    }
}
