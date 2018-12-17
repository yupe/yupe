<?php

class m181213_214512_add_type_column extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{callback}}', 'type', 'integer DEFAULT 0');

	}

}