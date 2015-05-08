<?php

class m150414_180119_rename_date_fields extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->renameColumn('{{blog_blog}}', 'create_date', 'create_time');
        $this->renameColumn('{{blog_blog}}', 'update_date', 'update_time');

        $this->renameColumn('{{blog_post}}', 'create_date', 'create_time');
        $this->renameColumn('{{blog_post}}', 'update_date', 'update_time');
        $this->renameColumn('{{blog_post}}', 'publish_date', 'publish_time');

        $this->renameColumn('{{blog_user_to_blog}}', 'create_date', 'create_time');
        $this->renameColumn('{{blog_user_to_blog}}', 'update_date', 'update_time');
    }
}