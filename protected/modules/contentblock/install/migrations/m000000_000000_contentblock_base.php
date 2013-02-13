<?php
/**
 * ContentBlock install migration
 * Класс миграций для модуля ContentBlock:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * ContentBlock install migration
 * Класс миграций для модуля ContentBlock:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 */
class m000000_000000_contentblock_base extends CDbMigration
{
    /**
     * Накатываем миграцию:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $options = Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
        $this->createTable(
            $db->tablePrefix . 'content_block', array(
                'id' => 'pk',
                'name' => 'string NOT NULL',
                'code' => 'string NOT NULL',
                'type' => "tinyint(4) NOT NULL DEFAULT '1'",
                'content' => "text NOT NULL",
                'description' => "varchar(300) DEFAULT NULL"
            ), $options
        );

        $this->createIndex($db->tablePrefix . "contentblock_code_unique", $db->tablePrefix . 'content_block', "code", true);
        $this->createIndex($db->tablePrefix . "contentblock_type", $db->tablePrefix . 'content_block', "type", false);
    }
 
    /**
     * Откатываем миграцию:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $db = $this->getDbConnection();
        /**
         * Убиваем внешние ключи, индексы и таблицу - content_block
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable($db->tablePrefix . 'content_block') !== null) {
            /*
            $this->dropIndex($db->tablePrefix . "contentblock_code_unique", $db->tablePrefix . 'content_block');
            $this->dropIndex($db->tablePrefix . "contentblock_type", $db->tablePrefix . 'content_block');
            */
            $this->dropTable($db->tablePrefix . 'content_block');
        }
    }
}