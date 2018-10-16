<?php

class m160415_055344_add_manager_to_order extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{store_order}}', 'manager_id', 'integer');
        $this->addForeignKey('fk_{{store_order}}_manager', '{{store_order}}', 'manager_id', '{{user_user}}', 'id', 'SET NULL', 'CASCADE');
	}

	public function safeDown()
	{
        $this->dropForeignKey('fk_{{store_order}}_manager', '{{store_order}}');
        $this->dropColumn('{{store_order}}', 'manager_id');
	}
}