<?php

/**
 * Comment NestedSets install migration
 * Класс миграций для модуля Comment добавляющий поля
 * для использования NestedSets:
 *
 * @category YupeMigration
 * @package  yupe.modules.comment.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m130704_095200_comment_nestedsets extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{comment_comment}}', 'level', 'integer DEFAULT 0');
        $this->addColumn('{{comment_comment}}', 'root', 'integer DEFAULT 0');
        $this->addColumn('{{comment_comment}}', 'lft', 'integer DEFAULT 0');
        $this->addColumn('{{comment_comment}}', 'rgt', 'integer DEFAULT 0');

        $this->createIndex('ix_{{comment_comment}}_level', '{{comment_comment}}', "level", false);
        $this->createIndex('ix_{{comment_comment}}_root', '{{comment_comment}}', "root", false);
        $this->createIndex('ix_{{comment_comment}}_lft', '{{comment_comment}}', "lft", false);
        $this->createIndex('ix_{{comment_comment}}_rgt', '{{comment_comment}}', "rgt", false);
    }

    public function safeDown()
    {
        $this->dropIndex('ix_{{comment_comment}}_level', '{{comment_comment}}');
        $this->dropIndex('ix_{{comment_comment}}_root', '{{comment_comment}}');
        $this->dropIndex('ix_{{comment_comment}}_lft', '{{comment_comment}}');
        $this->dropIndex('ix_{{comment_comment}}_rgt', '{{comment_comment}}');

        $this->dropColumn('{{comment_comment}}', 'level');
        $this->dropColumn('{{comment_comment}}', 'root');
        $this->dropColumn('{{comment_comment}}', 'lft');
        $this->dropColumn('{{comment_comment}}', 'rgt');
    }
}
