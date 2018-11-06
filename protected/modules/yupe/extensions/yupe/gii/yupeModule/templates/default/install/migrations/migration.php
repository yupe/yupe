<?=  "<?php\n"; ?>
/**
 * <?=  ucfirst($this->moduleID); ?> install migration
 * Класс миграций для модуля <?=  ucfirst($this->moduleID); ?>:
 *
 * @category YupeMigration
 * @package  yupe.modules.<?=  $this->moduleID; ?>.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     https://yupe.ru
 **/
class m000000_000000_<?=  $this->moduleID; ?>_base extends yupe\components\DbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return null
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{<?=  $this->moduleID; ?>}}',
            [
                'id'             => 'pk',
                //для удобства добавлены некоторые базовые поля, которые могут пригодиться.
                'create_user_id' => "integer NOT NULL",
                'update_user_id' => "integer NOT NULL",
                'create_time'    => 'datetime NOT NULL',
                'update_time'    => 'datetime NOT NULL',
            ],
            $this->getOptions()
        );

        //ix
        $this->createIndex("ix_{{<?=  $this->moduleID; ?>}}_create_user", '{{<?=  $this->moduleID; ?>}}', "create_user_id", false);
        $this->createIndex("ix_{{<?=  $this->moduleID; ?>}}_update_user", '{{<?=  $this->moduleID; ?>}}', "update_user_id", false);
        $this->createIndex("ix_{{<?=  $this->moduleID; ?>}}_create_time", '{{<?=  $this->moduleID; ?>}}', "create_time", false);
        $this->createIndex("ix_{{<?=  $this->moduleID; ?>}}_update_time", '{{<?=  $this->moduleID; ?>}}', "update_time", false);

    }

    /**
     * Функция удаления таблицы:
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{<?=  $this->moduleID; ?>}}');
    }
}
