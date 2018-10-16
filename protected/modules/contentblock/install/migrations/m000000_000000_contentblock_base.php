<?php

/**
 * ContentBlock install migration
 * Класс миграций для модуля ContentBlock:
 *
 * @category YupeMigration
 * @package  yupe.modules.contentblock.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_contentblock_base extends yupe\components\DbMigration
{

    public function safeUp()
    {
        $this->createTable(
            '{{contentblock_content_block}}',
            [
                'id'          => 'pk',
                'name'        => 'varchar(250) NOT NULL',
                'code'        => 'varchar(100) NOT NULL',
                'type'        => "integer NOT NULL DEFAULT '1'",
                'content'     => "text NOT NULL",
                'description' => "varchar(255) DEFAULT NULL"
            ],
            $this->getOptions()
        );

        $this->createIndex("ux_{{contentblock_content_block}}_code", '{{contentblock_content_block}}', "code", true);
        $this->createIndex("ix_{{contentblock_content_block}}_type", '{{contentblock_content_block}}', "type", false);
    }

    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{contentblock_content_block}}');
    }
}
