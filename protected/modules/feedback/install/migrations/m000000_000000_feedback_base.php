<?php

/**
 * Feedback install migration
 * Класс миграций для модуля Feedback:
 *
 * @category YupeMigration
 * @package  yupe.modules.feedback.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_feedback_base extends yupe\components\DbMigration
{
    /**
     * Накатываем миграцию
     *
     * @return null
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{feedback_feedback}}',
            [
                'id'            => 'pk',
                'category_id'   => 'integer DEFAULT NULL',
                'answer_user'   => 'integer DEFAULT NULL',
                'creation_date' => 'datetime NOT NULL',
                'change_date'   => 'datetime NOT NULL',
                'name'          => 'varchar(150) NOT NULL',
                'email'         => 'varchar(150) NOT NULL',
                'phone'         => 'varchar(150) DEFAULT NULL',
                'theme'         => 'varchar(250) NOT NULL',
                'text'          => 'text NOT NULL',
                'type'          => "integer NOT NULL DEFAULT '0'",
                'answer'        => 'text NOT NULL',
                'answer_date'   => 'datetime DEFAULT NULL',
                'is_faq'        => "integer NOT NULL DEFAULT '0'",
                'status'        => "integer NOT NULL DEFAULT '0'",
                'ip'            => 'varchar(20) NOT NULL',
            ],
            $this->getOptions()
        );

        //ix
        $this->createIndex("ix_{{feedback_feedback}}_category", '{{feedback_feedback}}', "category_id", false);
        $this->createIndex("ix_{{feedback_feedback}}_type", '{{feedback_feedback}}', "type", false);
        $this->createIndex("ix_{{feedback_feedback}}_status", '{{feedback_feedback}}', "status", false);
        $this->createIndex("ix_{{feedback_feedback}}_isfaq", '{{feedback_feedback}}', "is_faq", false);
        $this->createIndex("ix_{{feedback_feedback}}_answer_user", '{{feedback_feedback}}', "answer_user", false);

        //fk
        $this->addForeignKey(
            "fk_{{feedback_feedback}}_answer_user",
            '{{feedback_feedback}}',
            'answer_user',
            '{{user_user}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );
        $this->addForeignKey(
            "fk_{{feedback_feedback}}_category",
            '{{feedback_feedback}}',
            'category_id',
            '{{category_category}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );
    }

    /**
     * Откатываем миграцию
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{feedback_feedback}}');
    }
}
