<?php

class m141110_090000_store_export_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{store_export}}",
            [
                "id" => "pk",
                "name" => "varchar(255) not null",
                "settings" => "text null default null",
            ],
            $this->getOptions()
        );
    }

    public function safeDown()
    {
        $this->dropTable("{{store_export}}");
    }
}
