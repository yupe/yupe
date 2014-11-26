<?php

class m140115_132045_auth_item_child extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            '{{user_user_auth_item_child}}',
            [
                'parent' => "char(64) NOT NULL",
                'child'  => "char(64) NOT NULL",
            ],
            $this->getOptions()

        );

        $this->addPrimaryKey(
            "pk_{{user_user_auth_item_child}}_parent_child",
            '{{user_user_auth_item_child}}',
            'parent,child'
        );
        $this->addForeignKey(
            "fk_{{user_user_auth_item_child}}_child",
            '{{user_user_auth_item_child}}',
            'child',
            '{{user_user_auth_item}}',
            'name',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            "fk_{{user_user_auth_itemchild}}_parent",
            '{{user_user_auth_item_child}}',
            'parent',
            '{{user_user_auth_item}}',
            'name',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{user_user_auth_item_child}}');
    }
}
