<?php

class m130310_135201_menu_regular_links extends YDbMigration
{
	public function safeUp()
    {        
        $this->addColumn("{{menu_menu_item}}", "regular_link", "boolean");
    }
 
    /**
     * Откатываем миграцию:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $this->dropColumn("{{menu_menu_item}}", "regular_link");
    }
}