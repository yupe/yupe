<?php
/**
 * FileDocComment
 * Blog install migration
 * Класс миграций для модуля Blog:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Blog install migration
 * Класс миграций для модуля Blog:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 *
 * Add category relations to blog
 */
class m121231_184100_blog_category extends CDbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();

        // blog
        $this->addColumn($db->tablePrefix . 'blog', 'category_id', 'integer DEFAULT NULL');

        $this->createIndex($db->tablePrefix . "blog_category_idx", $db->tablePrefix . 'blog', "category_id", false);
        $this->addForeignKey($db->tablePrefix . "blog_category_fk", $db->tablePrefix . 'blog', 'category_id', $db->tablePrefix.'category', 'id', 'SET NULL', 'CASCADE');
    }

    /**
     * Откат миграции:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $db = $this->getDbConnection();
        /**
         * Убиваем внешние ключи, индексы и таблицу - post_to_tag
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable($db->tablePrefix . 'post_to_tag') !== null) {
            if (in_array($db->tablePrefix . "blog_category_fk", $db->schema->getTable($db->tablePrefix . 'blog')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "blog_category_fk", $db->tablePrefix . 'blog');
            /*
            $this->dropIndex($db->tablePrefix . "blog_category_idx", $db->tablePrefix . 'blog');
            */
            if (in_array($db->tablePrefix . "category_id", $db->schema->getTable($db->tablePrefix . 'blog')->columns))
                $this->dropColumn($db->tablePrefix . 'blog', 'category_id');
        }
    }
}