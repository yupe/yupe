<?php

/**
 * File Doc Comment
 * Menu install migration
 * Класс миграций для модуля Menu:
 *
 * @category YupeMigration
 * @package  yupe.modules.menu.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_menu_base extends yupe\components\DbMigration
{

    public function safeUp()
    {
        $this->createTable(
            '{{menu_menu}}',
            [
                'id'          => 'pk',
                'name'        => 'varchar(255) NOT NULL',
                'code'        => 'string NOT NULL',
                'description' => 'varchar(255) NOT NULL',
                'status'      => "integer NOT NULL DEFAULT '1'",
            ],
            $this->getOptions()
        );

        //ix
        $this->createIndex("ux_{{menu_menu}}_code", '{{menu_menu}}', "code", true);
        $this->createIndex("ix_{{menu_menu}}_status", '{{menu_menu}}', "status", false);

        /**
         * menu_item:
         **/
        $this->createTable(
            '{{menu_menu_item}}',
            [
                'id'               => 'pk',
                'parent_id'        => 'integer NOT NULL',
                'menu_id'          => 'integer NOT NULL',
                'regular_link'     => "boolean NOT NULL DEFAULT '0'",
                'title'            => 'varchar(150) NOT NULL',
                'href'             => 'varchar(150) NOT NULL',
                'class'            => 'varchar(150) NOT NULL',
                'title_attr'       => 'varchar(150) NOT NULL',
                'before_link'      => 'varchar(150) NOT NULL',
                'after_link'       => 'varchar(150) NOT NULL',
                'target'           => 'varchar(150) NOT NULL',
                'rel'              => 'varchar(150) NOT NULL',
                'condition_name'   => "varchar(150) DEFAULT '0'",
                'condition_denial' => "integer DEFAULT '0'",
                'sort'             => "integer NOT NULL DEFAULT '1'",
                'status'           => "integer NOT NULL DEFAULT '1'",
            ],
            $this->getOptions()
        );

        $this->createIndex("ix_{{menu_menu_item}}_menu_id", '{{menu_menu_item}}', "menu_id", false);
        $this->createIndex("ix_{{menu_menu_item}}_sort", '{{menu_menu_item}}', "sort", false);
        $this->createIndex("ix_{{menu_menu_item}}_status", '{{menu_menu_item}}', "status", false);

        //fk
        $this->addForeignKey(
            "fk_{{menu_menu_item}}_menu_id",
            '{{menu_menu_item}}',
            'menu_id',
            '{{menu_menu}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{menu_menu_item}}');
        $this->dropTableWithForeignKeys('{{menu_menu}}');
    }
}
