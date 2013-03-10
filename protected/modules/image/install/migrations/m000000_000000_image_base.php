<?php
/**
 * FileDocComment
 * Image install migration
 * Класс миграций для модуля Image:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_image_base extends YDbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return null
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{image_image}}',
            array(
                'id' => 'pk',
                'category_id' => 'integer DEFAULT NULL',
                'parent_id' => 'integer DEFAULT NULL',
                'name' => 'varchar(300) NOT NULL',
                'description' => 'text',
                'file' => 'varchar(500) NOT NULL',
                'creation_date' => 'datetime NOT NULL',
                'user_id' => 'integer DEFAULT NULL',
                'alt' => 'string NOT NULL',
                'type' => "integer NOT NULL DEFAULT '0'",
                'status' => "integer NOT NULL DEFAULT '1'",
            ),
            $this->getOptions()
        );

        //ix
        $this->createIndex("ix_{{image_image}}_status", '{{image_image}}', "status", false);
        $this->createIndex("ix_{{image_image}}_user", '{{image_image}}', "user_id", false);
        $this->createIndex("ix_{{image_image}}_type", '{{image_image}}', "type", false);
        $this->createIndex("ix_{{image_image}}_category_id", '{{image_image}}', "category_id", false);

        //fk
        $this->addForeignKey("fk_{{image_image}}_category_fk", '{{image_image}}', 'category_id', '{{category_category}}', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey("fk_{{image_image}}_user_fk", '{{image_image}}', 'user_id', '{{user_user}}', 'id', 'SET NULL', 'CASCADE');
    }

    /**
     * Функция удаления таблицы:
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{image_image}}');
    }
}