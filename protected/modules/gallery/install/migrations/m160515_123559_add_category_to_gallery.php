<?php

class m160515_123559_add_category_to_gallery extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->addColumn('{{gallery_gallery}}', 'category_id', 'integer DEFAULT NULL');
        $this->addForeignKey(
            'fk_{{gallery_gallery}}_gallery_to_category',
            '{{gallery_gallery}}',
            'category_id',
            '{{category_category}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );

    }

	public function safeDown()
	{
        $this->dropForeignKey('fk_{{gallery_gallery}}_gallery_to_category', '{{gallery_gallery}}');
        $this->dropColumn('{{gallery_gallery}}', 'category_id');
	}
}