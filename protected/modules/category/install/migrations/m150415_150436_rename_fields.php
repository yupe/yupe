<?php

class m150415_150436_rename_fields extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->renameColumn('{{category_category}}', 'alias', 'slug');
    }
}