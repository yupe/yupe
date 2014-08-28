<?php

/**
 * m130115_155600_columns_rename install migration
 * Класс миграций для модуля Page:
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.page.install.migrations
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @since 0.1
 *
 */
class m140620_072543_add_view extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{page_page}}', 'view', 'varchar(250)');
    }

    public function safeDown()
    {
        $this->dropColumn('{{page_page}}', 'view');
    }
}
