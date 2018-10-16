<?php

class m161125_181730_add_url_to_callback extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{callback}}', 'url', 'TEXT');
	}
}