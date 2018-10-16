<?php

class m150127_130425_add_status_column extends \yupe\components\DbMigration
{
    public function up()
    {
        $this->addColumn('{{contentblock_content_block}}', 'status', 'tinyint(1) NOT NULL DEFAULT 1');

        $this->createIndex('ix_{{contentblock_content_block}}_status', '{{contentblock_content_block}}', 'status');
    }

    public function down()
    {
        $this->dropColumn('{{contentblock_content_block}}', 'status');
    }

    /*
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}