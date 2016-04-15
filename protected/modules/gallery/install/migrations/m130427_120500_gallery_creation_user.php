<?php

/**
 * Gallery install migration
 * Класс миграций для модуля Gallery:
 *
 * @category YupeMigration
 * @package  yupe.modules.gallery.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m130427_120500_gallery_creation_user extends yupe\components\DbMigration
{
    /**
     * Накатываем миграцию
     *
     * @return null
     **/
    public function safeUp()
    {
        // add owner column
        $this->addColumn('{{gallery_gallery}}', 'owner', 'integer DEFAULT NULL');

        //add index for column
        $this->createIndex("ix_{{gallery_gallery}}_owner", '{{gallery_gallery}}', "owner", false);

        //add foreign key to users
        $this->addForeignKey(
            "fk_{{gallery_gallery}}_owner",
            '{{gallery_gallery}}',
            'owner',
            '{{user_user}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );
    }

    /**
     * Откатываем миграцию
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropForeignKey('fk_{{gallery_gallery}}_owner', '{{gallery_gallery}}');

        $this->dropIndex('ix_{{gallery_gallery}}_owner', '{{gallery_gallery}}');

        $this->dropColumn('{{gallery_gallery}}', 'owner');
    }
}
