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
        $options = Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
        /**
         * gallery:
         **/
        $this->createTable(
            $db->tablePrefix . 'gallery', array(
                'id' => 'pk',
                'name' =>'varchar(300) NOT NULL',
                'description' => 'text',
                'status' => "tinyint(4) NOT NULL DEFAULT '1'",
            ), $options
        );

        $this->createIndex($db->tablePrefix . "gallery_status", $db->tablePrefix . 'gallery', "status", false);

        /**
         * image_to_gallery:
         **/
        $this->createTable(
            $db->tablePrefix . 'image_to_gallery', array(
                'id' => 'pk',
                'image_id'  =>  'integer NOT NULL',
                'gallery_id' => 'integer NOT NULL',
                'creation_date' => 'datetime NOT NULL',
            ), $options
        );

        $this->createIndex($db->tablePrefix . "gallery_to_image_unique", $db->tablePrefix . 'image_to_gallery', "image_id, gallery_id", true);
        $this->createIndex($db->tablePrefix . "gallery_to_image_image", $db->tablePrefix . 'image_to_gallery', "image_id", false);
        $this->createIndex($db->tablePrefix . "gallery_to_image_gallery", $db->tablePrefix . 'image_to_gallery', "gallery_id", false);

        $this->addForeignKey($db->tablePrefix . "gallery_to_image_gallery_fk", $db->tablePrefix . 'image_to_gallery', 'gallery_id', $db->tablePrefix . 'gallery', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey($db->tablePrefix . "gallery_to_image_image_fk", $db->tablePrefix . 'image_to_gallery', 'image_id', $db->tablePrefix . 'image', 'id', 'CASCADE', 'CASCADE');
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
            $this->createIndex("gallery_to_image_unique", $db->tablePrefix . 'image_to_gallery', "image_id,gallery_id", true);
            $this->createIndex("gallery_to_image_image", $db->tablePrefix . 'image_to_gallery', "image_id", false);
            $this->createIndex("gallery_to_image_gallery", $db->tablePrefix . 'image_to_gallery', "gallery_id", false);
            */

            if (in_array($db->tablePrefix . "gallery_to_image_gallery_fk", $db->schema->getTable($db->tablePrefix . 'image_to_gallery')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "gallery_to_image_gallery_fk", $db->tablePrefix . 'image_to_gallery');

            if (in_array($db->tablePrefix . "gallery_to_image_image_fk", $db->schema->getTable($db->tablePrefix . 'image_to_gallery')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "gallery_to_image_gallery_fk", $db->tablePrefix . 'image_to_gallery');

            $this->dropTable($db->tablePrefix . 'image_to_gallery');
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