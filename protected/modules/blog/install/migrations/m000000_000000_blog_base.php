<?php
class m000000_000000_blog_base extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();

        // blog

        $tableName = $db->tablePrefix.'blog';
        $this->createTable($tableName, array(
            'id' => 'pk',
            'name' => 'varchar(300) NOT NULL',
            'description' => "text NOT NULL DEFAULT ''",
            'icon' => "varchar(300) NOT NULL DEFAULT ''",
            'slug' => 'varchar(150) NOT NULL',
            'lang' => 'char(2) DEFAULT NULL',
            'type' => "tinyint(4) unsigned NOT NULL DEFAULT '1'",
            'status' => "tinyint(4) unsigned NOT NULL DEFAULT '1'",
            'create_user_id' => 'integer NOT NULL',
            'update_user_id' => 'integer NOT NULL',
            'create_date' => 'integer unsigned NOT NULL',
            'update_date' => 'integer unsigned NOT NULL',
        ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("blog_slug_uniq",$tableName,"slug,lang", true);
        $this->createIndex("blog_create_user_id",$tableName,"create_user_id", false);
        $this->createIndex("blog_update_user_id",$tableName,"update_user_id", false);
        $this->createIndex("blog_status",$tableName,"status", false);
        $this->createIndex("blog_type",$tableName,"type", false);
        $this->createIndex("blog_create_date",$tableName,"create_date", false);
        $this->createIndex("blog_update_date",$tableName,"update_date", false);
        $this->createIndex("blog_lang",$tableName,"lang", false);
        $this->createIndex("blog_slug",$tableName,"slug", false);

        $this->addForeignKey("blog_create_user_fk",$tableName,'create_user_id',$db->tablePrefix.'user','id','CASCADE','CASCADE');
        $this->addForeignKey("blog_update_user_fk",$tableName,'update_user_id',$db->tablePrefix.'user','id','CASCADE','CASCADE');


        // post

        $tableName = $db->tablePrefix.'post';
        $this->createTable($tableName, array(
              'id' => 'pk',
              'blog_id' => 'integer NOT NULL',
              'create_user_id' => 'integer NOT NULL',
              'update_user_id' => 'integer NOT NULL',
              'create_date' => 'integer NOT NULL',
              'update_date' => 'integer NOT NULL',
              'publish_date' => 'integer NOT NULL',
              'slug' => 'string NOT NULL',
              'lang' => 'char(2) DEFAULT NULL',
              'title' => 'string NOT NULL',
              'quote' => "varchar(300) NOT NULL DEFAULT ''",
              'content' => 'text NOT NULL',
              'link' => "string NOT NULL DEFAULT ''",
              'status' => "tinyint(4) unsigned NOT NULL DEFAULT '0'",
              'comment_status' => "tinyint(4) unsigned NOT NULL DEFAULT '1'",
              'access_type' => "tinyint(4) unsigned NOT NULL DEFAULT '1'",
              'keywords' => "string NOT NULL DEFAULT ''",
              'description' => "varchar(300) NOT NULL DEFAULT ''",
            ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("blog_post_slug_uniq",$tableName,"slug,lang", true);
        $this->createIndex("blog_post_blog_id",$tableName,"blog_id", true);
        $this->createIndex("blog_post_create_user_id",$tableName,"create_user_id", false);
        $this->createIndex("blog_post_update_user_id",$tableName,"update_user_id", false);
        $this->createIndex("blog_post_status",$tableName,"status", false);
        $this->createIndex("blog_post_access_type",$tableName,"access_type", false);
        $this->createIndex("blog_post_comment_status",$tableName,"comment_status", false);
        $this->createIndex("blog_lang",$tableName,"lang", false);
        $this->createIndex("blog_slug",$tableName,"slug", false);

        $this->addForeignKey("blog_post_blog_fk",$tableName,'blog_id',$db->tablePrefix.'blog','id','CASCADE','CASCADE');
        $this->addForeignKey("blog_post_create_user_fk",$tableName,'create_user_id',$db->tablePrefix.'user','id','CASCADE','CASCADE');
        $this->addForeignKey("blog_post_update_user_fk",$tableName,'update_user_id',$db->tablePrefix.'user','id','CASCADE','CASCADE');

        // user to blog

        $tableName = $db->tablePrefix.'user_to_blog';
        $this->createTable($tableName, array(
                'id' => 'pk',
                'user_id' => 'integer NOT NULL',
                'blog_id' => 'integer NOT NULL',
                'create_date' => 'integer NOT NULL',
                'update_date' => 'integer NOT NULL',
                'role' => "tinyint(3) unsigned NOT NULL DEFAULT '1'",
                'status' => "smallint(5) unsigned NOT NULL DEFAULT '1'",
                'note' => "varchar(300) NOT NULL DEFAULT ''",
            ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("blog_user_to_blog_uniq",$tableName,"user_id,blog_id", true);
        $this->createIndex("blog_user_to_blog_uid",$tableName,"user_id", false);
        $this->createIndex("blog_user_to_blog_blogid",$tableName,"blog_id", false);
        $this->createIndex("blog_user_to_blog_status",$tableName,"status", false);
        $this->createIndex("blog_user_to_blog_role",$tableName,"role", false);

        $this->addForeignKey("blog_user_to_blog_user_id",$tableName,'user_id',$db->tablePrefix.'user','id','CASCADE','CASCADE');
        $this->addForeignKey("blog_user_to_blog_blog_id",$tableName,'blog_id',$db->tablePrefix.'blog','id','CASCADE','CASCADE');

        // tags

        $tableName = $db->tablePrefix.'tag';
        $this->createTable($tableName, array(
                'id' => 'pk',
                'name' => 'string NOT NULL',
            ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("blog_tag_name_uniq",$tableName,"name", true);

        // post to tag

        $tableName = $db->tablePrefix.'post_to_tag';
        $this->createTable($tableName, array(
                'post_id' => 'integer NOT NULL',
                'tag_id' => 'integer NOT NULL',
                'PRIMARY KEY (post_id, tag_id)'
            ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("blog_post_to_tag_postid",$tableName,"post_id", false);
        $this->createIndex("blog_post_to_tag_tagid",$tableName,"tag_id", false);

        $this->addForeignKey("blog_post_to_tag_postid_fk",$tableName,'post_id',$db->tablePrefix.'post','id','CASCADE','CASCADE');
        $this->addForeignKey("blog_post_to_tag_tagid_fk",$tableName,'tag_id',$db->tablePrefix.'tag','id','CASCADE','CASCADE');

    }
 
    public function safeDown()
    {
        $db = $this->getDbConnection();

        $this->dropTable($db->tablePrefix.'post_to_tag');
        $this->dropTable($db->tablePrefix.'tag');
        $this->dropTable($db->tablePrefix.'user_to_blog');
        $this->dropTable($db->tablePrefix.'post');
        $this->dropTable($db->tablePrefix.'blog');
    }
}