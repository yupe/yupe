<?php

class m140812_100348_add_expire_to_token_table extends CDbMigration
{
    public function safeUp()
    {
        UserToken::model()->deleteAll();

        $this->addColumn('{{user_tokens}}', 'expire', 'datetime NOT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('{{user_tokens}}', 'expire');
    }
}
