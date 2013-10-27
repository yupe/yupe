<?php
/**
 * Prepare hash field for replace password/salt fields
 * Класс миграций для модуля User:
 *
 * @category YupeMigration
 * @package  yupe.modules.user.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

class m131026_002234_prepare_hash_user_password extends yupe\components\DbMigration
{
    public function safeUp()
    {
    	$this->addColumn(
        	'{{user_user}}',
        	'hash',
        	'string not null default '
        	. (
        		Yii::app()->getDb()->getSchema() instanceof CPgsqlSchema
        			? 'md5(random()::text)'
        			: 'MD5(RAND())'
        	)
        );
        
        $this->dropColumn('{{user_user}}', 'password');
        $this->dropColumn('{{user_user}}', 'salt');
    }

    public function safeDown()
    {
        $this->addColumn(
        	'{{user_user}}',
        	'password',
        	'char(32) NOT NULL DEFAULT '
        	. (
        		Yii::app()->getDb()->getSchema() instanceof CPgsqlSchema
        			? 'md5(random()::text)'
        			: 'MD5(RAND())'
        	)
        );
        
        $this->addColumn(
        	'{{user_user}}',
        	'salt',
        	'char(32) NOT NULL DEFAULT '
        	. (
        		Yii::app()->getDb()->getSchema() instanceof CPgsqlSchema
        			? 'md5(random()::text)'
        			: 'MD5(RAND())'
        	)
        );
        
        $this->dropColumn('{{user_user}}', 'hash');
    }
}