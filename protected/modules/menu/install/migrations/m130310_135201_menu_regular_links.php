<?php

class m130310_135201_menu_regular_links extends CDbMigration
{
	public function safeUp()
    {
        $db = $this->getDbConnection();
        
        $this->addColumn($db->tablePrefix . 'menu_menu_item', 'regular_link', 'boolean');
    }
 
    /**
     * Откатываем миграцию:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $db = $this->getDbConnection();

        $this->dropColumn($db->tablePrefix . 'menu_menu_item', 'regular_link');
    }
}