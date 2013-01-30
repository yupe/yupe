<?php
/**
 * File Doc Comment
 * Menu install migration
 * Класс миграций для модуля Menu:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Menu install migration
 * Класс миграций для модуля Menu:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_menu_base extends CDbMigration
{
    /**
     * Накатываем миграцию:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();

        /**
         * menu:
         **/
        $this->createTable(
            $db->tablePrefix . 'menu', array(
                'id' => 'pk',
                'name' => 'varchar(300) NOT NULL',
                'code' => 'string NOT NULL',
                'description' => 'varchar(300) NOT NULL',
                'status'=> "tinyint(3) unsigned NOT NULL DEFAULT '1'",
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex($db->tablePrefix . "menu_code_unique", $db->tablePrefix . 'menu', "code", true);
        $this->createIndex($db->tablePrefix . "menu_status", $db->tablePrefix . 'menu', "status", false);

        /**
         * menu_item:
         **/
        $this->createTable(
            $db->tablePrefix . 'menu_item', array(
                'id' => 'pk',
                'parent_id' => 'integer NOT NULL',
                'menu_id' => 'integer NOT NULL',
                'title' => 'string NOT NULL',
                'href' => 'string NOT NULL',
                'class' => 'string NOT NULL',
                'title_attr' => 'string NOT NULL',
                'before_link' => 'string NOT NULL',
                'after_link' => 'string NOT NULL',
                'target' => 'string NOT NULL',
                'rel' => 'string NOT NULL',
                'condition_name' => "string DEFAULT '0'",
                'condition_denial' => "tinyint(4) DEFAULT '0'",
                'sort' => "tinyint(3) unsigned NOT NULL DEFAULT '1'",
                'status' => "tinyint(3) unsigned NOT NULL DEFAULT '1'",
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex($db->tablePrefix . "menu_item_menuid", $db->tablePrefix . 'menu_item', "menu_id", false);
        $this->createIndex($db->tablePrefix . "menu_item_sort", $db->tablePrefix . 'menu_item', "sort", false);
        $this->createIndex($db->tablePrefix . "menu_item_status", $db->tablePrefix . 'menu_item', "status", false);

        $this->addForeignKey($db->tablePrefix . "menu_item_menu_fk", $db->tablePrefix . 'menu_item', 'menu_id', $db->tablePrefix . 'menu', 'id', 'CASCADE', 'CASCADE');
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
         * Убиваем внешние ключи, индексы и таблицу - mail_event
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable($db->tablePrefix . 'menu_item') !== null) {

            /*
            $this->dropIndex($db->tablePrefix . "menu_item_status", $db->tablePrefix . 'menu_item');
            $this->dropIndex($db->tablePrefix . "menu_item_sort", $db->tablePrefix . 'menu_item');
            $this->dropIndex($db->tablePrefix . "menu_item_menuid", $db->tablePrefix . 'menu_item');
            */

            if (in_array($db->tablePrefix . "menu_item_menu_fk", $db->schema->getTable($db->tablePrefix . 'menu_item')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "menu_item_menu_fk", $db->tablePrefix . 'menu_item');

            $this->dropTable($db->tablePrefix . 'menu_item');
        }
        
        /**
         * Убиваем внешние ключи, индексы и таблицу - mail_event
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable($db->tablePrefix . 'menu') !== null) {

            /*
            $this->dropIndex($db->tablePrefix . "menu_status", $db->tablePrefix . 'menu');
            $this->dropIndex($db->tablePrefix . "menu_code_unique", $db->tablePrefix . 'menu');
            */

            $this->dropTable($db->tablePrefix . 'menu');
        }
    }
}