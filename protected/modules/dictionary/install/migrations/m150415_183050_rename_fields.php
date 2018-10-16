<?php

class m150415_183050_rename_fields extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->renameColumn('{{dictionary_dictionary_data}}', 'creation_date', 'create_time');
        $this->renameColumn('{{dictionary_dictionary_data}}', 'update_date', 'update_time');

        $this->renameColumn('{{dictionary_dictionary_group}}', 'creation_date', 'create_time');
        $this->renameColumn('{{dictionary_dictionary_group}}', 'update_date', 'update_time');
	}
}