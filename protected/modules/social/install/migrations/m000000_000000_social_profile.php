<?php

class m000000_000000_social_profile extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            '{{social_user}}',
            [
                'id'       => 'pk',
                'user_id'  => 'integer NOT NULL',
                'provider' => 'varchar(250) NOT NULL',
                'uid'      => 'varchar(250) NOT NULL',
            ],
            $this->getOptions()
        );

        //ix
        $this->createIndex("ix_{{social_user}}_provider", '{{social_user}}', "provider");
        $this->createIndex("ux_{{social_user}}_uid", '{{social_user}}', "uid", true);

        //fk
        $this->addForeignKey(
            "fk_{{social_user}}_user_id",
            '{{social_user}}',
            'user_id',
            '{{user_user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{social_user}}');
    }
}
