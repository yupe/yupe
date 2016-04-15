<?php

/**
 * Yupe install migration
 * Класс миграций для модуля Yupe
 *
 * @category YupeMigration
 * @package  yupe.modules.user.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m130527_154455_yupe_change_unique_index extends yupe\components\DbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return null
     **/
    public function safeUp()
    {
        //Delete old unique index:
        $this->dropIndex("ux_{{yupe_settings}}_module_id_param_name", '{{yupe_settings}}');

        // Create new unique index:
        $this->createIndex(
            "ux_{{yupe_settings}}_module_id_param_name_user_id",
            '{{yupe_settings}}',
            "module_id,param_name,user_id",
            true
        );
    }

    /**
     * Функция удаления таблицы:
     *
     * @return null
     **/
    public function safeDown()
    {
        //Delete old unique index:
        $this->dropIndex("ux_{{yupe_settings}}_module_id_param_name_user_id", '{{yupe_settings}}');

        // Create new unique index:
        $this->createIndex(
            "ux_{{yupe_settings}}_module_id_param_name",
            '{{yupe_settings}}',
            "module_id,param_name",
            true
        );
    }
}
