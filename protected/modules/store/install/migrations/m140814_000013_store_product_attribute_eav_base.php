<?php

class m140814_000013_store_product_attribute_eav_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{store_product_attribute_eav}}",
            [
                "product_id" => "integer not null",
                "attribute" => "varchar(250) not null",
                "value" => "text",
            ],
            $this->getOptions()
        );

        $this->createIndex("ix_{{store_product_attribute_eav}}_product_id", "{{store_product_attribute_eav}}", "product_id", false);
        $this->createIndex("ix_{{store_product_attribute_eav}}_attribute", "{{store_product_attribute_eav}}", "attribute", false);

        //fk
        $this->addForeignKey("fk_{{store_product_attribute_eav}}_product", "{{store_product_attribute_eav}}", "product_id", "{{store_product}}", "id", "CASCADE", "CASCADE");
        $this->addForeignKey("fk_{{store_product_attribute_eav}}_attribute", "{{store_product_attribute_eav}}", "attribute", "{{store_attribute}}", "name", "CASCADE", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{store_product_attribute_eav}}");
    }
}
