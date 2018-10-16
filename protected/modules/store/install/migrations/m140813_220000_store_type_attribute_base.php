<?php

class m140813_220000_store_type_attribute_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{store_type_attribute}}",
            [
                "type_id" => "int(11) not null",
                "attribute_id" => "int(11) not null",
            ],
            $this->getOptions()
        );
        $this->addPrimaryKey("pk_{{store_type_attribute}}", "{{store_type_attribute}}", "type_id, attribute_id");

        $this->addForeignKey("fk_{{store_type_attribute}}_type", "{{store_type_attribute}}", "type_id", "{{store_type}}", "id", "CASCADE", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{store_type_attribute}}");
    }
}
