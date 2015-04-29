<?php

class m150416_101038_rename_fields extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->renameColumn('{{page_page}}', 'creation_date', 'create_time');
        $this->renameColumn('{{page_page}}', 'change_date', 'update_time');
    }
}