<?php

/**
 * Dictionary install migration
 * Класс миграций для модуля Dictionary:
 *
 * @category YupeMigration
 * @package  yupe.modules.dictionary.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 *
 **/
class m000000_000000_dictionary_base extends yupe\components\DbMigration
{

    public function safeUp()
    {
        $this->createTable(
            '{{dictionary_dictionary_group}}',
            [
                'id'             => 'pk',
                'code'           => 'varchar(100) NOT NULL',
                'name'           => "varchar(250) NOT NULL",
                'description'    => "varchar(250) NOT NULL DEFAULT ''",
                'creation_date'  => 'datetime NOT NULL',
                'update_date'    => 'datetime NOT NULL',
                'create_user_id' => 'integer DEFAULT NULL',
                'update_user_id' => 'integer DEFAULT NULL',
            ],
            $this->getOptions()
        );

        //ix
        $this->createIndex("ux_{{dictionary_dictionary_group}}_code", '{{dictionary_dictionary_group}}', "code", true);
        $this->createIndex(
            "ix_{{dictionary_dictionary_group}}_create_user_id",
            '{{dictionary_dictionary_group}}',
            "create_user_id",
            false
        );
        $this->createIndex(
            "ix_{{dictionary_dictionary_group}}_update_user_id",
            '{{dictionary_dictionary_group}}',
            "update_user_id",
            false
        );

        //fk
        $this->addForeignKey(
            "fk_{{dictionary_dictionary_group}}_create_user_id",
            '{{dictionary_dictionary_group}}',
            'create_user_id',
            '{{user_user}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );
        $this->addForeignKey(
            "fk_{{dictionary_dictionary_group}}_update_user_id",
            '{{dictionary_dictionary_group}}',
            'update_user_id',
            '{{user_user}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );

        /**
         * Dictionary_data
         **/
        $this->createTable(
            '{{dictionary_dictionary_data}}',
            [
                'id'             => 'pk',
                'group_id'       => 'integer NOT NULL',
                'code'           => 'varchar(100) NOT NULL',
                'name'           => 'varchar(250) NOT NULL',
                'value'          => 'varchar(250) NOT NULL',
                'description'    => "varchar(250) NOT NULL DEFAULT ''",
                'creation_date'  => 'datetime NOT NULL',
                'update_date'    => 'datetime NOT NULL',
                'create_user_id' => 'integer DEFAULT NULL',
                'update_user_id' => 'integer DEFAULT NULL',
                'status'         => "integer NOT NULL DEFAULT '1'",
            ],
            $this->getOptions()
        );

        //ix
        $this->createIndex(
            "ux_{{dictionary_dictionary_data}}_code_unique",
            '{{dictionary_dictionary_data}}',
            "code",
            true
        );
        $this->createIndex(
            "ix_{{dictionary_dictionary_data}}_group_id",
            '{{dictionary_dictionary_data}}',
            "group_id",
            false
        );
        $this->createIndex(
            "ix_{{dictionary_dictionary_data}}_create_user_id",
            '{{dictionary_dictionary_data}}',
            "create_user_id",
            false
        );
        $this->createIndex(
            "ix_{{dictionary_dictionary_data}}_update_user_id",
            '{{dictionary_dictionary_data}}',
            "update_user_id",
            false
        );
        $this->createIndex(
            "ix_{{dictionary_dictionary_data}}_status",
            '{{dictionary_dictionary_data}}',
            "status",
            false
        );

        //fk
        $this->addForeignKey(
            "fk_{{dictionary_dictionary_data}}_create_user_id",
            '{{dictionary_dictionary_data}}',
            'create_user_id',
            '{{user_user}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );
        $this->addForeignKey(
            "fk_{{dictionary_dictionary_data}}_update_user_id",
            '{{dictionary_dictionary_data}}',
            'update_user_id',
            '{{user_user}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );
        $this->addForeignKey(
            "fk_{{dictionary_dictionary_data}}_data_group_id",
            '{{dictionary_dictionary_data}}',
            'group_id',
            '{{dictionary_dictionary_group}}',
            'id',
            'CASCADE',
            'NO ACTION'
        );
    }

    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{dictionary_dictionary_data}}');
        $this->dropTableWithForeignKeys('{{dictionary_dictionary_group}}');
    }
}
