<?php

class m140115_131455_auth_item extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            '{{user_user_auth_item}}',
            [
                'name'        => "char(64) NOT NULL",
                'type'        => "integer NOT NULL",
                'description' => "text",
                'bizrule'     => "text",
                'data'        => "text",
            ],
            $this->getOptions()
        );

        $this->addPrimaryKey("pk_{{user_user_auth_item}}_name", '{{user_user_auth_item}}', 'name');
        $this->createIndex("ix_{{user_user_auth_item}}_type", '{{user_user_auth_item}}', "type", false);
    }

    public function safeDown()
    {
        $this->dropTable('{{user_user_auth_item}}');
    }
}
