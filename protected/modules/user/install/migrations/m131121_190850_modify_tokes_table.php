<?php

class m131121_190850_modify_tokes_table extends CDbMigration
{
    public function safeUp()
    {
        $this->addForeignKey(
            "fk_{{user_tokens}}_user_id",
            '{{user_tokens}}',
            'user_id',
            '{{user_user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->alterColumn("{{user_tokens}}", 'token', 'varchar(255)');
    }

    public function safeDown()
    {
        $this->dropForeignKey("fk_{{user_tokens}}_user_id", "{{user_tokens}}");
        $this->alterColumn("{{user_tokens}}", 'token', 'varchar(32)');
    }
}
