<?php

/**
 * m130503_091124_BlogPostImage
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
class m130503_091124_BlogPostImage extends yupe\components\DbMigration
{

    public function safeUp()
    {
        $this->addColumn('{{blog_post}}', 'image', 'varchar(300) DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('{{blog_post}}', 'image');
    }
}
