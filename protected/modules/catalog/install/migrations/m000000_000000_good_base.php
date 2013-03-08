<?php
/**
 * Catalog install migration
 * Класс миграций для модуля Catalog:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_good_base extends YDbMigration
{
    /**
     * Накатываем миграцию:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $this->createTable('{{catalog_good}}', array(
                'id' => 'pk',
                'category_id' => 'integer NOT NULL',
                'name' => 'varchar(250) NOT NULL',
                'price' => "decimal(19,3) NOT NULL DEFAULT '0'",
                'article' => 'varchar(100) DEFAULT NULL',
                'image' => 'varchar(250) DEFAULT NULL',
                'short_description' => 'text',
                'description' => 'text NOT NULL',
                'alias' => 'varchar(150) NOT NULL',
                'data' => 'text',
                'is_special' => "boolean NOT NULL DEFAULT '0'",
                'status' => "boolean NOT NULL DEFAULT '1'",
                'create_time' => 'datetime NOT NULL',
                'update_time' => 'datetime NOT NULL',
                'user_id' => 'integer DEFAULT NULL',
                'change_user_id' => 'integer DEFAULT NULL',
            ), $this->getOptions()
        );

        $this->createIndex("ux_{{catalog_good}}_alias", '{{catalog_good}}', "alias", true);
        $this->createIndex("ix_{{catalog_good}}_status", '{{catalog_good}}', "status", false);
        $this->createIndex("ix_{{catalog_good}}_category", '{{catalog_good}}', "category_id", false);
        $this->createIndex("ix_{{catalog_good}}_user", '{{catalog_good}}', "user_id", false);
        $this->createIndex("ix_{{catalog_good}}_change_user", '{{catalog_good}}', "change_user_id", false);
        $this->createIndex("ix_{{catalog_good}}_article", '{{catalog_good}}', "article", false);
        $this->createIndex("ix_{{catalog_good}}_price", '{{catalog_good}}', "price", false);

        $this->addForeignKey("fk_{{catalog_good}}_user",'{{catalog_good}}', 'user_id', '{{user}}', 'id', 'SET NULL', 'NO ACTION');
        $this->addForeignKey("fk_{{catalog_good}}_change_user",'{{catalog_good}}', 'change_user_id','{{user}}', 'id', 'SET NULL', 'NO ACTION');
        $this->addForeignKey("fk_{{catalog_good}}_category",'{{catalog_good}}', 'category_id', '{{category}}', 'id', 'SET NULL', 'NO ACTION');
    }
 
    /**
     * Откат миграции:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $this->dropTable('{{catalog_good}}');
    }
}