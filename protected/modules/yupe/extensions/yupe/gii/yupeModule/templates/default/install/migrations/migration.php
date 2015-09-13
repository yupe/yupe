<?php echo "<?php\n"; ?>
/**
 * <?php echo ucfirst($this->moduleID); ?> install migration
 * Класс миграций для модуля <?php echo ucfirst($this->moduleID); ?>:
 *
 * @category YupeMigration
 * @package  yupe.modules.<?php echo $this->moduleID; ?>.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_<?php echo $this->moduleID; ?>_base extends yupe\components\DbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return null
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{<?php echo $this->moduleID; ?>}}',
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
        $this->createIndex("ix_{{<?php echo $this->moduleID; ?>}}_create_user", '{{<?php echo $this->moduleID; ?>}}', "create_user_id", false);
        $this->createIndex("ix_{{<?php echo $this->moduleID; ?>}}_update_user", '{{<?php echo $this->moduleID; ?>}}', "update_user_id", false);
        $this->createIndex("ix_{{<?php echo $this->moduleID; ?>}}_create_time", '{{<?php echo $this->moduleID; ?>}}', "create_time", false);
        $this->createIndex("ix_{{<?php echo $this->moduleID; ?>}}_update_time", '{{<?php echo $this->moduleID; ?>}}', "update_time", false);

    }

    /**
     * Функция удаления таблицы:
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{<?php echo $this->moduleID; ?>}}');
    }
}
