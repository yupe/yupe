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
class m000000_000000_gallery_base extends yupe\components\DbMigration
{
    /**
     * Накатываем миграцию
     *
     * @return null
     **/
    public function safeUp()
    {
        /**
         * gallery:
         **/
        $this->createTable(
            '{{gallery_gallery}}',
            [
                'id'          => 'pk',
                'name'        => 'varchar(250) NOT NULL',
                'description' => 'text',
                'status'      => "integer NOT NULL DEFAULT '1'",
            ],
            $this->getOptions()
        );

        $this->createIndex("ix_{{gallery_gallery}}_status", '{{gallery_gallery}}', "status", false);

        /**
         * image_to_gallery:
         **/
        $this->createTable(
            '{{gallery_image_to_gallery}}',
            [
                'id'            => 'pk',
                'image_id'      => 'integer NOT NULL',
                'gallery_id'    => 'integer NOT NULL',
                'creation_date' => 'datetime NOT NULL',
            ],
            $this->getOptions()
        );

        //ix
        $this->createIndex(
            "ux_{{gallery_image_to_gallery}}_gallery_to_image",
            '{{gallery_image_to_gallery}}',
            "image_id, gallery_id",
            true
        );
        $this->createIndex(
            "ix_{{gallery_image_to_gallery}}_gallery_to_image_image",
            '{{gallery_image_to_gallery}}',
            "image_id",
            false
        );
        $this->createIndex(
            "ix_{{gallery_image_to_gallery}}_gallery_to_image_gallery",
            '{{gallery_image_to_gallery}}',
            "gallery_id",
            false
        );

        //fk
        $this->addForeignKey(
            "fk_{{gallery_image_to_gallery}}_gallery_to_image_gallery",
            '{{gallery_image_to_gallery}}',
            'gallery_id',
            '{{gallery_gallery}}',
            'id',
            'CASCADE',
            'NO ACTION'
        );
        $this->addForeignKey(
            "fk_{{gallery_image_to_gallery}}_gallery_to_image_image",
            '{{gallery_image_to_gallery}}',
            'image_id',
            '{{image_image}}',
            'id',
            'CASCADE',
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
        $this->dropTableWithForeignKeys('{{gallery_image_to_gallery}}');
        $this->dropTableWithForeignKeys('{{gallery_gallery}}');
    }
}
