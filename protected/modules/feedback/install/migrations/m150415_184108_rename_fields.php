<?php

class m150415_184108_rename_fields extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->renameColumn('{{feedback_feedback}}', 'creation_date', 'create_time');
        $this->renameColumn('{{feedback_feedback}}', 'change_date', 'update_time');
        $this->renameColumn('{{feedback_feedback}}', 'answer_date', 'answer_time');
	}
}