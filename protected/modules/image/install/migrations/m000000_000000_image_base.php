<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aopeykin
 * Date: 05.02.13
 * Time: 10:38
 * To change this template use File | Settings | File Templates.
 */
class m000000_000000_image_base extends YDbMigration
{
    public function safeUp()
    {
        /**
         * image:
         **/
        $this->createTable(
            '{{image_image}}', array(
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
                'status' => "integer NOT NULL DEFAULT '1'",
            ), 
            $this->getOptions()
        );

        // ix
        $this->createIndex("ix_{{image_image}}_status", '{{image_image}}', "status", false);
        $this->createIndex("ix_{{image_image}}_user", '{{image_image}}', "user_id", false);
        $this->createIndex("ix_{{image_image}}_type", '{{image_image}}', "type", false);
        $this->createIndex("ix_{{image_image}}_category_id", '{{image_image}}', "category_id", false);

        // fk
        $this->addForeignKey(
            'fk_{{image_image}}_category',
            '{{image_image}}',
            'category_id',
            '{{category_category}}',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_{{image_image}}_user',
            '{{image_image}}',
            'user_id',
            '{{user}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{image_image}}'); 
    }
}
