<?php

class m181214_110527_menu_item_add_entity_fields extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{menu_menu_item}}', 'entity_module_name', 'varchar(40) DEFAULT NULL');
        $this->addColumn('{{menu_menu_item}}', 'entity_name', 'varchar(40) DEFAULT NULL');
        $this->addColumn('{{menu_menu_item}}', 'entity_id', 'integer(11) DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('{{menu_menu_item}}', 'entity_module_name');
        $this->dropColumn('{{menu_menu_item}}', 'entity_name');
        $this->dropColumn('{{menu_menu_item}}', 'entity_id');
    }
}