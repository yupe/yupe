<?php

class m160514_131314_add_preview_to_gallery extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{gallery_gallery}}', 'preview_id', 'integer');
        $this->addForeignKey(
            'fk_{{gallery_gallery}}_gallery_preview_to_image',
            '{{gallery_gallery}}',
            'preview_id',
            '{{image_image}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_{{gallery_gallery}}_gallery_preview_to_image', '{{gallery_gallery}}');
        $this->dropColumn('{{gallery_gallery}}', 'preview_id');
    }
}