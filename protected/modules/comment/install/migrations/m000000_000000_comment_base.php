<?php

/**
 * Comment install migration
 * Класс миграций для модуля Comment:
 *
 * @category YupeMigration
 * @package  yupe.modules.comment.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_comment_base extends yupe\components\DbMigration
{

    public function safeUp()
    {
        $this->createTable(
            '{{comment_comment}}',
            [
                'id'            => 'pk',
                'parent_id'     => 'integer DEFAULT NULL',
                'user_id'       => 'integer DEFAULT NULL',
                'model'         => 'varchar(100) NOT NULL',
                'model_id'      => 'integer NOT NULL',
                'url'           => 'varchar(150) DEFAULT NULL',
                'creation_date' => 'datetime NOT NULL',
                'name'          => 'varchar(150) NOT NULL',
                'email'         => 'varchar(150) NOT NULL',
                'text'          => 'text NOT NULL',
                'status'        => "integer NOT NULL DEFAULT '0'",
                'ip'            => 'varchar(20) DEFAULT NULL'
            ],
            $this->getOptions()
        );

        $this->createIndex("ix_{{comment_comment}}_status", '{{comment_comment}}', "status", false);
        $this->createIndex("ix_{{comment_comment}}_model_model_id", '{{comment_comment}}', "model, model_id", false);
        $this->createIndex("ix_{{comment_comment}}_model", '{{comment_comment}}', "model", false);
        $this->createIndex("ix_{{comment_comment}}_model_id", '{{comment_comment}}', "model_id", false);
        $this->createIndex("ix_{{comment_comment}}_user_id", '{{comment_comment}}', "user_id", false);
        $this->createIndex("ix_{{comment_comment}}_parent_id", '{{comment_comment}}', "parent_id", false);

        $this->addForeignKey(
            "fk_{{comment_comment}}_user_id",
            '{{comment_comment}}',
            'user_id',
            '{{user_user}}',
            'id',
            'CASCADE',
            'NO ACTION'
        );
        $this->addForeignKey(
            "fk_{{comment_comment}}_parent_id",
            '{{comment_comment}}',
            "parent_id",
            '{{comment_comment}}',
            "id",
            'CASCADE',
            'NO ACTION'
        );
    }

    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{comment_comment}}');
    }
}
