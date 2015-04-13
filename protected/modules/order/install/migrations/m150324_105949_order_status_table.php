<?php

class m150324_105949_order_status_table extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->createTable('{{store_order_status}}', [
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'is_system' => 'TINYINT(1) NOT NULL DEFAULT 0'
        ], $this->getOptions());

        $this->insertMultiple('{{store_order_status}}', [
            [
                'name' => 'Новый',
                'is_system' => 1
            ],
            [
                'name' => 'Принят',
                'is_system' => 1
            ],
            [
                'name' => 'Выполнен',
                'is_system' => 1
            ],
            [
                'name' => 'Удален',
                'is_system' => 1
            ],
        ]);

        Yii::app()->getDb()->createCommand('UPDATE {{store_order}} SET status = status + 1')->execute();
        
        $this->renameColumn('{{store_order}}', 'status', 'status_id');
        $this->alterColumn('{{store_order}}', 'status_id', 'integer null');
        $this->addForeignKey('fk_{{store_order}}_status', '{{store_order}}', 'status_id', '{{store_order_status}}', 'id', 'SET NULL', 'CASCADE');
	}

	public function safeDown()
	{
        $this->dropTable('{{store_order_status}}');
	}
}