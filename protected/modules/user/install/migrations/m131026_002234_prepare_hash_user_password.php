<?php

/**
 * Prepare hash field for replace password/salt fields
 * Класс миграций для модуля User:
 *
 * Так как MySQL не поддерживает 'Calculated default values'
 * http://stackoverflow.com/questions/4236912/how-to-create-calculated-field-in-mysql
 * мы генерируем случайную строку, которая запретит вход по старым паролям
 *
 *
 * @category YupeMigration
 * @package  yupe.modules.user.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m131026_002234_prepare_hash_user_password extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->addColumn(
            '{{user_user}}',
            'hash',
            'string not null default '
            . (
            Yii::app()->getDb()->getSchema() instanceof CPgsqlSchema
                ? 'md5(random()::text)'
                // Делаем невозможность входа
                // по старому паролю
                // (генерируется случайная строка):
                : '"' . md5(uniqid()) . microtime() . '"'
            )
        );

        $this->dropColumn('{{user_user}}', 'password');
        $this->dropColumn('{{user_user}}', 'salt');
    }

    public function safeDown()
    {
        $this->addColumn(
            '{{user_user}}',
            'password',
            'char(32) NOT NULL DEFAULT '
            . (
            Yii::app()->getDb()->getSchema() instanceof CPgsqlSchema
                ? 'md5(random()::text)'
                : '"' . md5(uniqid()) . microtime() . '"'
            )
        );

        $this->addColumn(
            '{{user_user}}',
            'salt',
            'char(32) NOT NULL DEFAULT '
            . (
            Yii::app()->getDb()->getSchema() instanceof CPgsqlSchema
                ? 'md5(random()::text)'
                : '"' . md5(uniqid()) . microtime() . '"'
            )
        );

        $this->dropColumn('{{user_user}}', 'hash');
    }
}
