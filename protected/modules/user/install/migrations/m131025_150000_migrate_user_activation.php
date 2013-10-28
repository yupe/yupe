<?php
/**
 * Migrate user activations
 * Класс миграций для модуля User:
 *
 * @category YupeMigration
 * @package  yupe.modules.user.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

// Импортируем нужные модели:
Yii::import('application.modules.user.models.User');

class m131025_150000_migrate_user_activation extends yupe\components\DbMigration
{
    public function safeUp()
    {
        foreach (User::model()->findAll() as $user) {
            // Определяем статус:
            $user->status = isset($this->activation_ip) && !empty($this->activation_ip)
                            ? User::STATUS_ACTIVE
                            : (int) $user->status;
            
            // обновляем статус:
            $user->update((array) 'status');
        }
    }

    public function safeDown()
    {
        // Очищаем таблицу:
        $this->truncateTable('{{user_tokens}}');
    }
}