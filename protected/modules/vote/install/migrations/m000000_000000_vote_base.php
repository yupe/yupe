<?php
/**
 * File Doc Comment
 * Vote install migration
 * Класс миграций для модуля Vote:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Vote install migration
 * Класс миграций для модуля Vote:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_vote_base extends YDbMigration
{
    /**
     * Накатываем миграцию:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{vote_vote}}', array(
                'id' => 'pk',
                'model' => 'varchar(150) NOT NULL',
                'model_id' => 'integer NOT NULL',
                'user_id' => 'integer NOT NULL',
                'creation_date' => 'datetime NOT NULL',
                'value'  => 'integer NOT NULL',
            ), $this->getOptions()
        );

        $this->createIndex("ix_{{vote_vote}}_user", '{{vote_vote}}', "user_id", false);
        $this->createIndex("ix_{{vote_vote}}_model_model_id", '{{vote_vote}}', "model,model_id", false);
        $this->createIndex("ix_{{vote_vote}}_model", '{{vote_vote}}', "model", false);
        $this->createIndex("ix_{{vote_vote}}_model_id", '{{vote_vote}}', "model_id", false);

        $this->addForeignKey("fk_{{vote_vote}}_user", '{{vote_vote}}', 'user_id', '{{user_user}}', 'id', 'CASCADE', 'CASCADE');
    }
 
    /**
     * Откатываем миграцию:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $db = $this->getDbConnection();

        /**
         * Убиваем внешние ключи, индексы и таблицу - vote
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable('{{vote_vote}}') !== null) {

            if (in_array("fk_{{vote_vote}}_user", $db->schema->getTable('{{vote_vote}}')->foreignKeys))
                $this->dropForeignKey("fk_{{vote_vote}}_user", '{{vote_vote}}');
            
            $this->dropTable('{{vote_vote}}');
        }
    }
}