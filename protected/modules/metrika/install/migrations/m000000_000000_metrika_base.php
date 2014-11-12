<?php
/**
 * News install migration
 * Класс миграций для модуля Metrika
 *
 * @category YupeMigration
 * @package  yupe.modules.metrika.install.migrations
 * @author   apexwire <apexwire@amylabs.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_metrika_base extends yupe\components\DbMigration
{

    public function safeUp()
    {
        $this->createTable(
            '{{metrika_url}}',
            array(
                'id' => 'pk',
                'url' => 'varchar(150) NOT NULL',
                'views' => 'integer NOT NULL DEFAULT "1"',
            ), $this->getOptions()
        );
        $this->createIndex("ux_{{metrika_url}}_url", '{{metrika_url}}', "url", true);


        $this->createTable(
            '{{metrika_transitions}}',
            array(
                'id' => 'pk',
                'url_id' => 'integer NOT NULL',
                'date' => 'datetime NOT NULL',
                'params_get'=> 'varchar(250) DEFAULT NULL',
            ), $this->getOptions()
        );
    }
 

    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{metrika_url}}');
        $this->dropTableWithForeignKeys('{{metrika_transitions}}');
    }
}