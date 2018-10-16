<?php

class m140115_132319_auth_item_assign extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            '{{user_user_auth_assignment}}',
            [
                'itemname' => "char(64) NOT NULL",
                'userid'   => "integer NOT NULL",
                'bizrule'  => "text",
                'data'     => "text",
            ],
            $this->getOptions()
        );

        $this->addPrimaryKey(
            "pk_{{user_user_auth_assignment}}_itemname_userid",
            '{{user_user_auth_assignment}}',
            'itemname,userid'
        );
        $this->addForeignKey(
            "fk_{{user_user_auth_assignment}}_user",
            '{{user_user_auth_assignment}}',
            'userid',
            '{{user_user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            "fk_{{user_user_auth_assignment}}_item",
            '{{user_user_auth_assignment}}',
            'itemname',
            '{{user_user_auth_item}}',
            'name',
            'CASCADE',
            'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{user_user_auth_assignment}}');
    }
}
