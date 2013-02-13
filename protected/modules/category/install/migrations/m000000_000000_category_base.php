<?php
/**
 * FileDocComment
 * Category install migration
 * Класс миграций для модуля Category:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Category install migration
 * Класс миграций для модуля Category:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_category_base extends CDbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $options = Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
        $this->createTable(
            $db->tablePrefix . 'category', array(
                'id' => 'pk',
                'parent_id' => 'integer DEFAULT NULL',
                'alias' => 'string NOT NULL',
                'lang' => 'char(2) DEFAULT NULL',
                'name' => 'string NOT NULL',
                'image' => 'varchar(300) DEFAULT NULL',
                'short_description' => 'text',
                'description' => 'text NOT NULL',
                'status' => "smallint(1) NOT NULL DEFAULT '1'",
            ), $options
        );

        $this->createIndex($db->tablePrefix . "category_alias_uniq", $db->tablePrefix . 'category', "alias,lang", true);
        $this->createIndex($db->tablePrefix . "category_parent_id", $db->tablePrefix . 'category', "parent_id", false);
        $this->createIndex($db->tablePrefix . "category_status", $db->tablePrefix . 'category', "status", false);

        $this->addForeignKey($db->tablePrefix . "category_parent_id_fk", $db->tablePrefix . 'category', 'parent_id', $db->tablePrefix . 'category', 'id', 'RESTRICT', 'NO ACTION');
    }
 
    /**
     * Функция удаления таблицы:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $db = $this->getDbConnection();

        /**
         * Убиваем внешние ключи, индексы и таблицу - settings
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/

        if ($db->schema->getTable($db->tablePrefix . 'category') !== null) {
            /*
            $this->dropIndex($db->tablePrefix . "category_alias_uniq", $db->tablePrefix . 'category');
            $this->dropIndex($db->tablePrefix . "category_parent_id", $db->tablePrefix . 'category');
            $this->dropIndex($db->tablePrefix . "category_status", $db->tablePrefix . 'category');
            */
            $this->dropTable($db->tablePrefix . 'category');
        }
    }
}