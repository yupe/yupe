<?php

class m150226_121100_image_order extends CDbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{image_image}}', 'sort', "integer NOT NULL DEFAULT '1'");

        $items = Image::model()->findAll();

        if ($items) {
            foreach ($items as $item) {
                $item->sort = $item->id;
                $item->update('sort');
            }
        }
	}

	public function safeDown()
	{
        $this->dropColumn('{{image_image}}', 'sort');
	}
}