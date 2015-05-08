<?php

class m150416_113652_rename_fields extends CDbMigration
{
	public function safeUp()
	{
        $this->renameColumn('{{user_user}}', 'change_date', 'update_time');
        $this->renameColumn('{{user_user}}', 'last_visit', 'visit_time');
        $this->renameColumn('{{user_user}}', 'registration_date', 'create_time');

        $this->renameColumn('{{user_tokens}}', 'created', 'create_time');
        $this->renameColumn('{{user_tokens}}', 'updated', 'update_time');
        $this->renameColumn('{{user_tokens}}', 'expire', 'expire_time');
	}
}