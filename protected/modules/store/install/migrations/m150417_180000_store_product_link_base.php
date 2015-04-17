<?php

class m150417_180000_store_product_link_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            '{{store_product_link_type}}',
            [
                'id' => 'pk',
                'code' => 'string not null',
                'title' => 'string not null',
            ],
            $this->getOptions()
        );

        $this->createIndex('ux_{{store_product_link_type}}_code', '{{store_product_link_type}}', 'code', true);
        $this->createIndex('ux_{{store_product_link_type}}_title', '{{store_product_link_type}}', 'title', true);

        $this->insert('{{store_product_link_type}}', ['code' => 'similar', 'title' => 'Похожие']);
        $this->insert('{{store_product_link_type}}', ['code' => 'related', 'title' => 'Сопутствующие']);

        $this->createTable(
            '{{store_product_link}}',
            [
                'id' => 'pk',
                'type_id' => 'int null',
                'product_id' => 'int not null',
                'linked_product_id' => 'int not null',
            ],
            $this->getOptions()
        );

        $this->createIndex('ux_{{store_product_link}}_product', '{{store_product_link}}', ['product_id', 'linked_product_id'], true);

        $this->addForeignKey('fk_{{store_product_link}}_product', '{{store_product_link}}', 'product_id', '{{store_product}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_{{store_product_link}}_linked_product', '{{store_product_link}}', 'linked_product_id', '{{store_product}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_{{store_product_link}}_type', '{{store_product_link}}', 'type_id', '{{store_product_link_type}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{store_product_link_type}}');
        $this->dropTable('{{store_product_link}}');
    }
}
