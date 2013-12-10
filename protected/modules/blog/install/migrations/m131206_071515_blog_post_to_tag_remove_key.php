<?php
/**
 * m131206_071515_blog_post_to_tag_remove_key
 *
 * Blog install migration
 * Класс миграций для модуля Blog:
 *
 * @category YupeMigration
 * @package  yupe.modules.blog.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

class m131206_071515_blog_post_to_tag_remove_key extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->dropPrimaryKey('post_id', '{{blog_post_to_tag}}');
    }

    public function safeDown()
    {
    }
}