<?php
/**
 * Gallery install migration
 * Класс миграций для модуля Gallery:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Gallery install migration
 * Класс миграций для модуля Gallery:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 */
class m000000_000000_gallery_base extends CDbMigration
{
    /**
     * Накатываем миграцию
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix . 'gallery';

        /**
         * gallery:
         **/
        $this->createTable(
            $db->tablePrefix . 'gallery', array(
                'id' => 'pk',
                'name' =>'varchar(300) NOT NULL',
                'description' => 'text',
                'status' => "tinyint(4) NOT NULL DEFAULT '1'",
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex($db->tablePrefix . "gallery_status", $db->tablePrefix . 'gallery', "status", false);

        /**
         * image:
         **/
        $this->createTable(
            $db->tablePrefix . 'image', array(
                'id' => 'pk',
                'category_id' => 'integer DEFAULT NULL',
                'parent_id' => 'integer DEFAULT NULL',
                'name' => 'varchar(300) NOT NULL',
                'description' => 'text',
                'file' => 'varchar(500) NOT NULL',
                'creation_date' => 'datetime NOT NULL',
                'user_id' => 'integer DEFAULT NULL',
                'alt' => 'string NOT NULL',
                'type' => "tinyint(4) NOT NULL DEFAULT '0'",
                'status' => "tinyint(3) unsigned NOT NULL DEFAULT '1'",
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex($db->tablePrefix . "gallery_image_status", $db->tablePrefix . 'image', "status", false);
        $this->createIndex($db->tablePrefix . "gallery_image_user", $db->tablePrefix . 'image', "user_id", false);
        $this->createIndex($db->tablePrefix . "gallery_image_type", $db->tablePrefix . 'image', "type", false);
        $this->createIndex($db->tablePrefix . "gallery_image_category_id", $db->tablePrefix . 'image', "category_id", false);

        $this->addForeignKey($db->tablePrefix . "gallery_image_category_fk", $db->tablePrefix . 'image', 'category_id', $db->tablePrefix . 'category', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey($db->tablePrefix . "gallery_image_user_fk", $db->tablePrefix . 'image', 'user_id', $db->tablePrefix . 'user', 'id', 'SET NULL', 'CASCADE');

        /**
         * image_to_gallery:
         **/
        $this->createTable(
            $db->tablePrefix . 'image_to_gallery', array(
                'id' => 'pk',
                'image_id'  =>  'integer NOT NULL',
                'galleryId' => 'integer NOT NULL',
                'creation_date' => 'datetime NOT NULL',
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex($db->tablePrefix . "gallery_to_image_unique", $db->tablePrefix . 'image_to_gallery', "image_id,galleryId", true);
        $this->createIndex($db->tablePrefix . "gallery_to_image_image", $db->tablePrefix . 'image_to_gallery', "image_id", false);
        $this->createIndex($db->tablePrefix . "gallery_to_image_gallery", $db->tablePrefix . 'image_to_gallery', "galleryId", false);

        $this->addForeignKey($db->tablePrefix . "gallery_to_image_gallery_fk", $db->tablePrefix . 'image_to_gallery', 'galleryId', $db->tablePrefix . 'gallery', 'id', 'CASCADE', 'CASCADE');



    }

    /**
     * Откатываем миграцию
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $db = $this->getDbConnection();

        /**
         * Убиваем внешние ключи, индексы и таблицу - image_to_gallery
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable($db->tablePrefix . 'image_to_gallery') !== null) {

            /*
            $this->createIndex("gallery_to_image_unique", $db->tablePrefix . 'image_to_gallery', "image_id,galleryId", true);
            $this->createIndex("gallery_to_image_image", $db->tablePrefix . 'image_to_gallery', "image_id", false);
            $this->createIndex("gallery_to_image_gallery", $db->tablePrefix . 'image_to_gallery', "galleryId", false);
            */

            if (in_array($db->tablePrefix . "gallery_to_image_gallery_fk", $db->schema->getTable($db->tablePrefix . 'image_to_gallery')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "gallery_to_image_gallery_fk", $db->tablePrefix . 'image_to_gallery');

            $this->dropTable($db->tablePrefix . 'image_to_gallery');
        }

        /**
         * Убиваем внешние ключи, индексы и таблицу - image
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable($db->tablePrefix . 'image') !== null) {

            /*
            $this->dropIndex($db->tablePrefix . "gallery_image_status", $db->tablePrefix . 'image');
            $this->dropIndex($db->tablePrefix . "gallery_image_user", $db->tablePrefix . 'image');
            $this->dropIndex($db->tablePrefix . "gallery_image_type", $db->tablePrefix . 'image');
            $this->dropIndex($db->tablePrefix . "gallery_image_category_id", $db->tablePrefix . 'image');
            */

            if (in_array($db->tablePrefix . "gallery_image_category_fk", $db->schema->getTable($db->tablePrefix . 'image')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "gallery_image_category_fk", $db->tablePrefix . 'image');

            if (in_array($db->tablePrefix . "gallery_image_user_fk", $db->schema->getTable($db->tablePrefix . 'image')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "gallery_image_user_fk", $db->tablePrefix . 'image');

            $this->dropTable($db->tablePrefix . 'image');
        }
        
        /**
         * Убиваем внешние ключи, индексы и таблицу - gallery
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable($db->tablePrefix . 'gallery') !== null) {
            
            /*
            $this->dropIndex($db->tablePrefix . "gallery_status", $db->tablePrefix . 'gallery');
            */
            
            $this->dropTable($db->tablePrefix . 'gallery');
        }

    }
}