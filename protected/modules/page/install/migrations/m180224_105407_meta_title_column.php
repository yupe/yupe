<?php

class m180224_105407_meta_title_column extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{page_page}}', 'meta_title', 'varchar(250) NOT NULL');
	}

}