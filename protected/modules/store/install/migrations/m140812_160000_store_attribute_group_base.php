<?php

class m140812_160000_store_attribute_group_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            '{{store_attribute_group}}',
            [
                'id' => 'pk',
                'name' => "varchar(255) not null",
                'position' => "integer not null default '1'",
            ],
            $this->getOptions()
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{store_attribute_group}}');
    }
}
