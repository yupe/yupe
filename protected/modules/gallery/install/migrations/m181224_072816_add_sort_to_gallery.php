<?php

class m181224_072816_add_sort_to_gallery extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{gallery_gallery}}', 'sort', 'integer NOT NULL DEFAULT 1');
        $this->createIndex("ix_{{gallery_gallery}}_sort", '{{gallery_gallery}}', "sort", false);

        Yii::app()->getDb()->createCommand('UPDATE {{gallery_gallery}} SET `sort` = `id`')->query();
    }

    public function safeDown()
    {
        $this->dropColumn('{{gallery_gallery}}', 'sort');
    }
}