<?php

class m160618_145025_add_status_color extends yupe\components\DbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{store_order_status}}', 'color', 'string');

        $default = [
            'default' => 'Новый',
            'info' => 'Принят',
            'success' => 'Выполнен',
            'danger' => 'Удален',
        ];

        foreach ($default as $color => $name) {
            Yii::app()
                ->getDb()
                ->createCommand()
                ->update('{{store_order_status}}', ['color' => $color], 'name = :name', [
                    ':name' => $name,
                ]);
        }
	}

	public function safeDown()
	{
        $this->dropColumn('{{store_order_status}}', 'color');
	}
}