<?php
/**
 * FileDocComment
 * Page install migration
 * Класс миграций для модуля Page:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Page install migration
 * Класс миграций для модуля Page:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 *
 * rename columns
 */
class m130115_155600_columns_rename extends YDbMigration
{
    /**
     * Накатываем миграцию:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $this->renameColumn("{{page_page}}", "menu_order", "order");
        $this->renameColumn("{{page_page}}", "name", "title_short");
    }

    /**
     * Откатываем миграцию:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        if (Yii::app()->db->schema->getTable("{{page_page}}") !== null)
        {

            if (isset(Yii::app()->db->schema->getTable('{{page_page}}')->columns['order']))
                $this->renameColumn("{{page_page}}", "order", "menu_order");

            if (isset(Yii::app()->db->schema->getTable('{{page_page}}')->columns['title_short']))
                $this->renameColumn("{{page_page}}", "title_short", "name");        
        }
    }
}