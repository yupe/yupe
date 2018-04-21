<?php

class m180421_143324_update_page_meta_column extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->renameColumn('{{page_page}}', 'keywords', 'meta_keywords');
        $this->renameColumn('{{page_page}}', 'description', 'meta_description');
    }
}