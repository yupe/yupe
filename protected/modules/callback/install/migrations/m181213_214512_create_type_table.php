<?php

class m181213_214512_create_type_table extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{callback}}', 'type', 'integer DEFAULT 0');

	}

}