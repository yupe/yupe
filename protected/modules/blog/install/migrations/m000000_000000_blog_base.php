<?php
/**
 * FileDocComment
 * Blog install migration
 * Класс миграций для модуля Blog:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Blog install migration
 * Класс миграций для модуля Blog:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_blog_base extends CDbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();

        // blog
        $this->createTable(
            $db->tablePrefix . 'blog', array(
                'id' => 'pk',
                'name' => 'varchar(300) NOT NULL',
                'description' => "text",
                'icon' => "varchar(300) NOT NULL DEFAULT ''",
                'slug' => 'varchar(150) NOT NULL',
                'lang' => 'char(2) DEFAULT NULL',
                'type' => "tinyint(4) unsigned NOT NULL DEFAULT '1'",
                'status' => "tinyint(4) unsigned NOT NULL DEFAULT '1'",
                'create_user_id' => 'integer NOT NULL',
                'update_user_id' => 'integer NOT NULL',
                'create_date' => 'integer unsigned NOT NULL',
                'update_date' => 'integer unsigned NOT NULL',
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex($db->tablePrefix . "blog_slug_uniq", $db->tablePrefix . 'blog', "slug,lang", true);
        $this->createIndex($db->tablePrefix . "blog_create_user_id", $db->tablePrefix . 'blog', "create_user_id", false);
        $this->createIndex($db->tablePrefix . "blog_update_user_id", $db->tablePrefix . 'blog', "update_user_id", false);
        $this->createIndex($db->tablePrefix . "blog_status", $db->tablePrefix . 'blog', "status", false);
        $this->createIndex($db->tablePrefix . "blog_type", $db->tablePrefix . 'blog', "type", false);
        $this->createIndex($db->tablePrefix . "blog_create_date", $db->tablePrefix . 'blog', "create_date", false);
        $this->createIndex($db->tablePrefix . "blog_update_date", $db->tablePrefix . 'blog', "update_date", false);
        $this->createIndex($db->tablePrefix . "blog_lang", $db->tablePrefix . 'blog', "lang", false);
        $this->createIndex($db->tablePrefix . "blog_slug", $db->tablePrefix . 'blog', "slug", false);

        $this->addForeignKey($db->tablePrefix . "blog_create_user_fk", $db->tablePrefix . 'blog', 'create_user_id', $db->tablePrefix . 'user', 'id', 'CASCADE',  'CASCADE');
        $this->addForeignKey($db->tablePrefix . "blog_update_user_fk", $db->tablePrefix . 'blog', 'update_user_id', $db->tablePrefix . 'user', 'id', 'CASCADE', 'CASCADE');


        // post
        $this->createTable(
            $db->tablePrefix . 'post', array(
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
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex($db->tablePrefix . "blog_post_slug_uniq", $db->tablePrefix . 'post', "slug,lang", true);
        $this->createIndex($db->tablePrefix . "blog_post_blog_id", $db->tablePrefix . 'post', "blog_id", false);
        $this->createIndex($db->tablePrefix . "blog_post_create_user_id", $db->tablePrefix . 'post', "create_user_id", false);
        $this->createIndex($db->tablePrefix . "blog_post_update_user_id", $db->tablePrefix . 'post', "update_user_id", false);
        $this->createIndex($db->tablePrefix . "blog_post_status", $db->tablePrefix . 'post', "status", false);
        $this->createIndex($db->tablePrefix . "blog_post_access_type", $db->tablePrefix . 'post', "access_type", false);
        $this->createIndex($db->tablePrefix . "blog_post_comment_status", $db->tablePrefix . 'post', "comment_status", false);
        $this->createIndex($db->tablePrefix . "blog_lang", $db->tablePrefix . 'post', "lang", false);
        $this->createIndex($db->tablePrefix . "blog_slug", $db->tablePrefix . 'post', "slug", false);

        $this->addForeignKey($db->tablePrefix . "blog_post_blog_fk", $db->tablePrefix . 'post', 'blog_id', $db->tablePrefix . 'blog', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey($db->tablePrefix . "blog_post_create_user_fk", $db->tablePrefix . 'post', 'create_user_id', $db->tablePrefix . 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey($db->tablePrefix . "blog_post_update_user_fk", $db->tablePrefix . 'post', 'update_user_id', $db->tablePrefix . 'user', 'id', 'CASCADE', 'CASCADE');

        // user to blog
        $this->createTable(
            $db->tablePrefix . 'user_to_blog', array(
                'id' => 'pk',
                'user_id' => 'integer NOT NULL',
                'blog_id' => 'integer NOT NULL',
                'create_date' => 'integer NOT NULL',
                'update_date' => 'integer NOT NULL',
                'role' => "tinyint(3) unsigned NOT NULL DEFAULT '1'",
                'status' => "smallint(5) unsigned NOT NULL DEFAULT '1'",
                'note' => "varchar(300) NOT NULL DEFAULT ''",
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex($db->tablePrefix . "blog_user_to_blog_uniq", $db->tablePrefix . 'user_to_blog', "user_id,blog_id", true);
        $this->createIndex($db->tablePrefix . "blog_user_to_blog_uid", $db->tablePrefix . 'user_to_blog', "user_id", false);
        $this->createIndex($db->tablePrefix . "blog_user_to_blog_blogid", $db->tablePrefix . 'user_to_blog', "blog_id", false);
        $this->createIndex($db->tablePrefix . "blog_user_to_blog_status", $db->tablePrefix . 'user_to_blog', "status", false);
        $this->createIndex($db->tablePrefix . "blog_user_to_blog_role", $db->tablePrefix . 'user_to_blog', "role", false);

        $this->addForeignKey("blog_user_to_blog_user_id", $db->tablePrefix . 'user_to_blog', 'user_id', $db->tablePrefix . 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey("blog_user_to_blog_blog_id", $db->tablePrefix . 'user_to_blog', 'blog_id', $db->tablePrefix . 'blog', 'id', 'CASCADE', 'CASCADE');

        // tags
        $this->createTable(
            $db->tablePrefix . 'tag', array(
                'id' => 'pk',
                'name' => 'string NOT NULL',
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex($db->tablePrefix . "blog_tag_name_uniq", $db->tablePrefix . 'tag', "name", true);

        // post to tag
        $this->createTable(
            $db->tablePrefix . 'post_to_tag', array(
                'post_id' => 'integer NOT NULL',
                'tag_id' => 'integer NOT NULL',
                'PRIMARY KEY (post_id, tag_id)'
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex($db->tablePrefix . "blog_post_to_tag_postid", $db->tablePrefix . 'post_to_tag', "post_id", false);
        $this->createIndex($db->tablePrefix . "blog_post_to_tag_tagid", $db->tablePrefix . 'post_to_tag', "tag_id", false);

        $this->addForeignKey($db->tablePrefix . "blog_post_to_tag_postid_fk", $db->tablePrefix . 'post_to_tag', 'post_id', $db->tablePrefix . 'post', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey($db->tablePrefix . "blog_post_to_tag_tagid_fk", $db->tablePrefix . 'post_to_tag', 'tag_id', $db->tablePrefix . 'tag', 'id', 'CASCADE', 'CASCADE');
    }
 
    /**
     * Удаляем талицу
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $db = $this->getDbConnection();

        /**
         * Убиваем внешние ключи, индексы и таблицу - post_to_tag
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        /*
        $this->dropIndex($db->tablePrefix . "blog_post_to_tag_postid", $db->tablePrefix . 'post_to_tag');
        $this->dropIndex($db->tablePrefix . "blog_post_to_tag_tagid", $db->tablePrefix . 'post_to_tag');
        */

        if ($db->schema->getTable($db->tablePrefix . 'post_to_tag') !== null) {
            if (in_array($db->tablePrefix . "blog_post_to_tag_postid_fk", $db->schema->getTable($db->tablePrefix . 'post_to_tag')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "blog_post_to_tag_postid_fk", $db->tablePrefix . 'post_to_tag');

            if (in_array($db->tablePrefix . "blog_post_to_tag_tagid_fk", $db->schema->getTable($db->tablePrefix . 'post_to_tag')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "blog_post_to_tag_tagid_fk", $db->tablePrefix . 'post_to_tag');
            
            $this->dropTable($db->tablePrefix . 'post_to_tag');
        }

        /**
         * Убиваем внешние ключи, индексы и таблицу - tag
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        /*
        $this->dropIndex($db->tablePrefix . "blog_tag_name_uniq", $db->tablePrefix . 'tag');
        */

        if ($db->schema->getTable($db->tablePrefix . 'tag') !== null) {
            $this->dropTable($db->tablePrefix . 'tag');
        }

        /**
         * Убиваем внешние ключи, индексы и таблицу - user_to_blog
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        /*
        $this->dropIndex($db->tablePrefix . "blog_user_to_blog_uniq", $db->tablePrefix . 'user_to_blog');
        $this->dropIndex($db->tablePrefix . "blog_user_to_blog_uid", $db->tablePrefix . 'user_to_blog');
        $this->dropIndex($db->tablePrefix . "blog_user_to_blog_blogid", $db->tablePrefix . 'user_to_blog');
        $this->dropIndex($db->tablePrefix . "blog_user_to_blog_status", $db->tablePrefix . 'user_to_blog');
        $this->dropIndex($db->tablePrefix . "blog_user_to_blog_role", $db->tablePrefix . 'user_to_blog');
        */
        
        if ($db->schema->getTable($db->tablePrefix . 'user_to_blog') !== null) {
            
            if (in_array($db->tablePrefix . "blog_user_to_blog_user_id", $db->schema->getTable($db->tablePrefix . 'user_to_blog')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "blog_user_to_blog_user_id", $db->tablePrefix . 'user_to_blog');

            if (in_array($db->tablePrefix . "blog_user_to_blog_blog_id", $db->schema->getTable($db->tablePrefix . 'user_to_blog')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "blog_user_to_blog_blog_id", $db->tablePrefix . 'user_to_blog');

            $this->dropTable($db->tablePrefix . 'user_to_blog');
        }
        
        /**
         * Убиваем внешние ключи, индексы и таблицу - post
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        /*
        $this->dropIndex($db->tablePrefix . "blog_post_slug_uniq", $db->tablePrefix . 'post');
        $this->dropIndex($db->tablePrefix . "blog_post_blog_id", $db->tablePrefix . 'post');
        $this->dropIndex($db->tablePrefix . "blog_post_create_user_id", $db->tablePrefix . 'post');
        $this->dropIndex($db->tablePrefix . "blog_post_update_user_id", $db->tablePrefix . 'post');
        $this->dropIndex($db->tablePrefix . "blog_post_status", $db->tablePrefix . 'post');
        $this->dropIndex($db->tablePrefix . "blog_post_access_type", $db->tablePrefix . 'post');
        $this->dropIndex($db->tablePrefix . "blog_post_comment_status", $db->tablePrefix . 'post');
        $this->dropIndex($db->tablePrefix . "blog_lang", $db->tablePrefix . 'post');
        $this->dropIndex($db->tablePrefix . "blog_slug", $db->tablePrefix . 'post');
        */

        if ($db->schema->getTable($db->tablePrefix . 'post') !== null) {
            if (in_array($db->tablePrefix . "blog_post_update_user_fk", $db->schema->getTable($db->tablePrefix . 'post')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "blog_post_update_user_fk", $db->tablePrefix . 'post');

            if (in_array($db->tablePrefix . "blog_post_create_user_fk", $db->schema->getTable($db->tablePrefix . 'post')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "blog_post_create_user_fk", $db->tablePrefix . 'post');

            if (in_array($db->tablePrefix . "blog_post_blog_fk", $db->schema->getTable($db->tablePrefix . 'post')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "blog_post_blog_fk", $db->tablePrefix . 'post');

            $this->dropTable($db->tablePrefix . 'post');
        }
        
        /**
         * Убиваем внешние ключи, индексы и таблицу - blog
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        /*
        $this->dropIndex($db->tablePrefix . "blog_slug_uniq", $db->tablePrefix . 'blog');
        $this->dropIndex($db->tablePrefix . "blog_create_user_id", $db->tablePrefix . 'blog');
        $this->dropIndex($db->tablePrefix . "blog_update_user_id", $db->tablePrefix . 'blog');
        $this->dropIndex($db->tablePrefix . "blog_status", $db->tablePrefix . 'blog');
        $this->dropIndex($db->tablePrefix . "blog_type", $db->tablePrefix . 'blog');
        $this->dropIndex($db->tablePrefix . "blog_create_date", $db->tablePrefix . 'blog');
        $this->dropIndex($db->tablePrefix . "blog_update_date", $db->tablePrefix . 'blog');
        $this->dropIndex($db->tablePrefix . "blog_lang", $db->tablePrefix . 'blog');
        $this->dropIndex($db->tablePrefix . "blog_slug", $db->tablePrefix . 'blog');
        */

        if ($db->schema->getTable($db->tablePrefix . 'blog') !== null) {
            
            if (in_array($db->tablePrefix . "blog_create_user_fk", $db->schema->getTable($db->tablePrefix . 'blog')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "blog_create_user_fk", $db->tablePrefix . 'blog');

            if (in_array($db->tablePrefix . "blog_update_user_fk", $db->schema->getTable($db->tablePrefix . 'blog')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "blog_update_user_fk", $db->tablePrefix . 'blog');

            $this->dropTable($db->tablePrefix . 'blog');
        }
    }
}