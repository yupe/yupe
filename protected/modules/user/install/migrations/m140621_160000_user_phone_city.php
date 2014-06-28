<?php


class m140621_160000_user_phone_city extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{user_user}}', 'phone', "varchar(30) NULL DEFAULT null");
        $this->addColumn('{{user_user}}', 'city', "varchar(100) NULL DEFAULT null");
    }

    public function safeDown()
    {
        $this->dropColumn('{{user_user}}', 'phone');
        $this->dropColumn('{{user_user}}', 'city');
    }
}