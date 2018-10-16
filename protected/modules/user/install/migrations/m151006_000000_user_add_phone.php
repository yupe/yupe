<?php

/**
 * Добавляем параметр "телефон"
 *
 * @category YupeMigration
 * @package  yupe.modules.user.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m151006_000000_user_add_phone extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{user_user}}', 'phone', 'char(30) DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('{{user_user}}', 'phone');
    }
}
