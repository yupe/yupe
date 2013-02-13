<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aopeykin
 * Date: 05.02.13
 * Time: 10:38
 * To change this template use File | Settings | File Templates.
 */
class m000000_000000_image_base extends  CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $options = Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
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
                'type' => "integer NOT NULL DEFAULT '0'",
                'status' => "integer unsigned NOT NULL DEFAULT '1'",
            ), $options
        );

        $this->createIndex($db->tablePrefix . "image_status", $db->tablePrefix . 'image', "status", false);
        $this->createIndex($db->tablePrefix . "image_user", $db->tablePrefix . 'image', "user_id", false);
        $this->createIndex($db->tablePrefix . "image_type", $db->tablePrefix . 'image', "type", false);
        $this->createIndex($db->tablePrefix . "image_category_id", $db->tablePrefix . 'image', "category_id", false);

        $this->addForeignKey($db->tablePrefix . "image_category_fk", $db->tablePrefix . 'image', 'category_id', $db->tablePrefix . 'category', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey($db->tablePrefix . "image_user_fk", $db->tablePrefix . 'image', 'user_id', $db->tablePrefix . 'user', 'id', 'SET NULL', 'CASCADE');
    }

    public function safeDown()
    {
        $db = $this->getDbConnection();
        /**
         * Убиваем внешние ключи, индексы и таблицу - image
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable($db->tablePrefix . 'image') !== null) {
            if (in_array($db->tablePrefix . "image_category_fk", $db->schema->getTable($db->tablePrefix . 'image')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "gallery_image_category_fk", $db->tablePrefix . 'image');

            if (in_array($db->tablePrefix . "image_user_fk", $db->schema->getTable($db->tablePrefix . 'image')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "image_user_fk", $db->tablePrefix . 'image');

            $this->dropTable($db->tablePrefix . 'image');
        }
    }
}
