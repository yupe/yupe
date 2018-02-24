<?php

class m180224_103745_add_agree_column extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{callback}}', 'agree', 'integer DEFAULT 0');

	}

}