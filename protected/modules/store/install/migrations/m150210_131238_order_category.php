<?php

class m150210_131238_order_category extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{store_category}}', 'sort', "integer NOT NULL DEFAULT '1'");

        $models = StoreCategory::model()->findAll();

        if ($models) {
            foreach ($models as $item) {
                $item->sort = (int)$item->id;
                $item->update('sort');
            }
        }
    }

    public function safeDown()
    {
        $this->dropColumn('{{store_category}}', 'sort');
    }
}
