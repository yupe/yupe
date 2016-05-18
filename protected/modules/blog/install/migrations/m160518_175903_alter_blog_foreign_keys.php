<?php

class m160518_175903_alter_blog_foreign_keys extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->dropForeignKey('fk_{{blog_blog}}_create_user', '{{blog_blog}}');
		$this->dropForeignKey('fk_{{blog_blog}}_update_user', '{{blog_blog}}');

		$this->addForeignKey(
			'fk_{{blog_blog}}_create_user',
			'{{blog_blog}}',
			'create_user_id',
			'{{user_user}}',
			'id',
			'RESTRICT',
			'NO ACTION'
		);
		$this->addForeignKey(
			'fk_{{blog_blog}}_update_user',
			'{{blog_blog}}',
			'update_user_id',
			'{{user_user}}',
			'id',
			'RESTRICT',
			'NO ACTION'
		);
	}
}