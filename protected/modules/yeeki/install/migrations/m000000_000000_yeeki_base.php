<?php
class m000000_000000_yeeki_base extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();

        $tableName = $db->tablePrefix.'wiki_page';
        $this->createTable($tableName, array(
                'id' => 'pk',
                'is_redirect' => "boolean DEFAULT '0'",
                'page_uid' => 'string DEFAULT NULL',
                'namespace' => 'string DEFAULT NULL',
                'content' => 'text',
                'revision_id' => 'integer DEFAULT NULL',
                'user_id' => 'integer DEFAULT NULL',
                'created_at' => 'integer DEFAULT NULL',
                'updated_at' => 'integer DEFAULT NULL',
            ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("wiki_page_revision",$tableName,"revision_id", false);
        $this->createIndex("wiki_page_uid",$tableName,"user_id", false);
        $this->createIndex("wiki_page_namespace",$tableName,"namespace", false);
        $this->createIndex("wiki_page_created",$tableName,"created_at", false);
        $this->createIndex("wiki_page_updated",$tableName,"updated_at", false);

        $this->addForeignKey("wiki_page_user_fk",$tableName,'user_id',$db->tablePrefix.'user','id','SET NULL','CASCADE');

        $tableName = $db->tablePrefix.'wiki_page_revision';
        $this->createTable($tableName, array(
                'id' => 'pk',
                'page_id' => 'integer NOT NULL',
                'comment' => 'string DEFAULT NULL',
                'is_minor' => 'boolean DEFAULT NULL',
                'content' => 'text',
                'user_id' => 'string DEFAULT NULL',
                'created_at' => 'integer DEFAULT NULL',
            ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");
        $this->createIndex("wiki_page_revision_pageid",$tableName,"page_id", false);
        $this->addForeignKey("wiki_page_revision_pagefk",$tableName,'page_id',$db->tablePrefix.'wiki_page','id','CASCADE','CASCADE');
        $this->addForeignKey("wiki_page_revision_fk",$db->tablePrefix."wiki_page",'revision_id',$db->tablePrefix.'wiki_page_revision','id','CASCADE','CASCADE');

        $tableName = $db->tablePrefix.'wiki_link';
        $this->createTable($tableName, array(
                'id' => 'pk',
                'page_from_id' => 'integer NOT NULL',
                'page_to_id' => 'integer DEFAULT NULL',
                'wiki_uid' => 'string DEFAULT NULL',
                'title' =>  'string DEFAULT NULL'
            ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("wiki_link_code_unique",$tableName,"page_from_id", false);
        $this->createIndex("wiki_link_status",$tableName,"page_to_id", false);
        $this->createIndex("wiki_link_uid",$tableName,"wiki_uid", false);

        $this->addForeignKey("wiki_link_page_from_fk",$tableName,'page_from_id',$db->tablePrefix.'wiki_page','id','CASCADE','CASCADE');
        $this->addForeignKey("wiki_link_page_to_fk",$tableName,'page_to_id',$db->tablePrefix.'wiki_page','id','CASCADE','CASCADE');


    }
 
    public function safeDown()
    {
        $db = $this->getDbConnection();

        // remove foreign keys prior to table drop to avoid loop
        // wiki_page_link
        $this->dropForeignKey("wiki_link_page_from_fk",$db->tablePrefix.'wiki_link');
        $this->dropForeignKey("wiki_link_page_to_fk",$db->tablePrefix.'wiki_link');

        // wiki_page_revision
        $this->dropForeignKey("wiki_page_revision_pagefk",$db->tablePrefix.'wiki_page_revision');
        $this->dropForeignKey("wiki_page_revision_fk",$db->tablePrefix.'wiki_page_revision');

        // wiki_page
        $this->dropForeignKey("wiki_page_user_fk",$db->tablePrefix.'wiki_page');

        $this->dropTable($db->tablePrefix.'wiki_page_revision');
        $this->dropTable($db->tablePrefix.'wiki_link');
        $this->dropTable($db->tablePrefix.'wiki_page');

    }
}