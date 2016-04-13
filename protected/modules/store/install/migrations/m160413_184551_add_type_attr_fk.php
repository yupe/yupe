<?php

class m160413_184551_add_type_attr_fk extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->addForeignKey("fk_{{store_type_attribute}}_attribute", "{{store_type_attribute}}", "attribute_id",
            "{{store_attribute}}", "id", "CASCADE", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropForeignKey("fk_{{store_type_attribute}}_attribute", "{{store_type_attribute}}");
    }
}