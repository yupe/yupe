<?php

/**
 * m130529_151602_add_post_category
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
class m130529_151602_add_post_category extends yupe\components\DbMigration
{
    public function safeUp()
    {
        //ix
        $this->addColumn('{{blog_post}}', 'category_id', 'integer DEFAULT NULL');
        $this->createIndex("ix_{{blog_post}}_category_id", '{{blog_post}}', "category_id", false);

        //fk
        $this->addForeignKey(
            "fk_{{blog_post}}_category_id",
            '{{blog_post}}',
            'category_id',
            '{{category_category}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_{{blog_post}}_category_id', '{{blog_post}}');
        $this->dropIndex('ix_{{blog_post}}_category_id', '{{blog_post}}');
        $this->dropColumn('{{blog_post}}', 'category_id');
    }
}
