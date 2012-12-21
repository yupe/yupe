<?php
class m000000_000000_gallery_base extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'gallery';
        $this->createTable($tableName, array(
            'id' => 'pk',
            'name' =>'varchar(300) NOT NULL',
            'description' => 'text',
            'status' => "tinyint(4) NOT NULL DEFAULT '1'",
        ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("gallery_status",$tableName,"status", false);

        $tableName = $db->tablePrefix.'image';
        $this->createTable($tableName, array(
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
            ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("gallery_image_status",$tableName,"status", false);
        $this->createIndex("gallery_image_user",$tableName,"user_id", false);
        $this->createIndex("gallery_image_type",$tableName,"type", false);
        $this->createIndex("gallery_image_category_id",$tableName,"category_id", false);

        $this->addForeignKey("gallery_image_category_fk",$tableName,'category_id',$db->tablePrefix.'category','id','CASCADE','CASCADE');
        $this->addForeignKey("gallery_image_user_fk",$tableName,'user_id',$db->tablePrefix.'user','id','SET NULL','CASCADE');

        $tableName = $db->tablePrefix.'image_to_gallery';
        $this->createTable($tableName, array(
                'id' => 'pk',
                'image_id'  =>  'integer NOT NULL',
                'galleryId' => 'integer NOT NULL',
                'creation_date' => 'datetime NOT NULL',
            ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("gallery_to_image_unique",$tableName,"image_id,galleryId", true);
        $this->createIndex("gallery_to_image_image",$tableName,"image_id", false);
        $this->createIndex("gallery_to_image_gallery",$tableName,"galleryId", false);

        $this->addForeignKey("gallery_to_image_gallery_fk",$tableName,'galleryId',$db->tablePrefix.'gallery','id','CASCADE','CASCADE');



    }
 
    public function safeDown()
    {
        $db = $this->getDbConnection();
        $this->dropTable($db->tablePrefix.'image_to_gallery');
        $this->dropTable($db->tablePrefix.'image');
        $this->dropTable($db->tablePrefix.'gallery');

    }
}