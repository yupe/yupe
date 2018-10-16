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
class m130115_155600_columns_rename extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->renameColumn('{{page_page}}', 'menu_order', 'order');
        $this->renameColumn('{{page_page}}', 'name', 'title_short');
    }

    public function safeDown()
    {
        $this->renameColumn('{{page_page}}', 'order', 'menu_order');
        $this->renameColumn('{{page_page}}', 'title_short', 'name');
    }
}
