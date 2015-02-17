<?php

class m150210_131238_order_category extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{store_category}}', 'sort', "integer NOT NULL DEFAULT '1'");
        $result = Yii::app()->db->createCommand("select * FROM {{store_category}}")->queryAll();
        if ($result) {
            foreach ($result as $item) {
                $query = "update {{store_category}} set sort = :id where id=:id";
                $command = Yii::app()->db->createCommand($query);
                $command->execute(array(
                        ':id' => $item['id']
                    )
                );
            }
        }
    }

    public function safeDown()
    {
        $this->dropColumn('{{store_category}}', 'sort');
    }
}
