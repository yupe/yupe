<?php

class m130503_091124_BlogPostImage extends yupe\components\DbMigration
{

	public function safeUp()
	{
        $this->addColumn('{{blog_post}}','image','varchar(300) DEFAULT NULL');
	}

	public function safeDown()
	{
        $this->dropColumn('{{blog_post}}','image');
	}
}