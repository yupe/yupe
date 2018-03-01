<?php

class m180224_105353_meta_title_column extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{news_news}}', 'meta_title', 'varchar(250) NOT NULL');

	}
}