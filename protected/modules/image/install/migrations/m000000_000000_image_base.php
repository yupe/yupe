<?php

/**
 * Image install migration
 * Класс миграций для модуля Image
 *
 * @category YupeMigration
 * @package  yupe.modules.image.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_image_base extends yupe\components\DbMigration
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
            [
                'id'            => 'pk',
                'category_id'   => 'integer DEFAULT NULL',
                'parent_id'     => 'integer DEFAULT NULL',
                'name'          => 'varchar(250) NOT NULL',
                'description'   => 'text',
                'file'          => 'varchar(250) NOT NULL',
                'creation_date' => 'datetime NOT NULL',
                'user_id'       => 'integer DEFAULT NULL',
                'alt'           => 'varchar(250) NOT NULL',
                'type'          => "integer NOT NULL DEFAULT '0'",
                'status'        => "integer NOT NULL DEFAULT '1'",
            ],
            $this->getOptions()
        );

        //ix
        $this->createIndex("ix_{{image_image}}_status", '{{image_image}}', "status", false);
        $this->createIndex("ix_{{image_image}}_user", '{{image_image}}', "user_id", false);
        $this->createIndex("ix_{{image_image}}_type", '{{image_image}}', "type", false);
        $this->createIndex("ix_{{image_image}}_category_id", '{{image_image}}', "category_id", false);

        //fk
        $this->addForeignKey(
            "fk_{{image_image}}_category_id",
            '{{image_image}}',
            'category_id',
            '{{category_category}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );
        $this->addForeignKey(
            "fk_{{image_image}}_user_id",
            '{{image_image}}',
            'user_id',
            '{{user_user}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );
        $this->addForeignKey(
            "fk_{{image_image}}_parent_id",
            '{{image_image}}',
            'parent_id',
            '{{image_image}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );
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
