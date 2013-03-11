<?php
/**
 * Initial application schema
 */
class m120213_183419_init extends YDbMigration
{
    public function up()
    {
        $db = Yii::app()->db;
        $options = Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
        $this->createTable(
            'wiki_page', array(
                'id' => 'pk',
                'is_redirect' => 'boolean DEFAULT 0',
                'page_uid' => 'string',
                'namespace' => 'string',
                'content' => 'text',
                'revision_id' => 'integer',
            ), $options
        );

        $this->createIndex($db->tablePrefix . 'wiki_idx_page_namespace', 'wiki_page', 'namespace');
        $this->createIndex($db->tablePrefix . 'wiki_idx_page_page_uid', 'wiki_page', 'page_uid', true);
        $this->createIndex($db->tablePrefix . 'wiki_idx_page_revision_id', 'wiki_page', 'revision_id', true);

        $this->createTable(
            'wiki_page_revision', array(
                'id' => 'pk',
                'page_id' => 'integer NOT NULL',
                'comment' => 'string',
                'is_minor' => 'boolean',
                'content' => 'text',
            ), $options
        );

        $this->addForeignKey($db->tablePrefix .'wiki_fk_page_revision_page_fk', 'wiki_page_revision', 'page_id', 'wiki_page', 'id', 'CASCADE');

        $this->createTable(
            'wiki_link', array(
                'id' => 'pk',
                'page_from_id' => 'integer NOT NULL',
                'page_to_id' => 'integer',
                'wiki_uid' => 'string',
                'title' => 'string',
            ), $options
        );

        $this->addForeignKey($db->tablePrefix .'wiki_fk_link_page_from_fk', 'wiki_link', 'page_from_id', 'wiki_page', 'id', 'CASCADE');
        $this->addForeignKey($db->tablePrefix .'wiki_fk_link_page_to_fk', 'wiki_link', 'page_to_id', 'wiki_page', 'id', 'SET NULL');
    }

    public function down()
    {
        $db = Yii::app()->db;
        $this->dropForeignKey($db->tablePrefix . 'wiki_fk_link_page_from', 'wiki_link');
        $this->dropForeignKey($db->tablePrefix . 'wiki_fk_link_page_to', 'wiki_link');
        $this->dropForeignKey($db->tablePrefix . 'wiki_fk_page_revision_page', 'wiki_page_revision');

        $this->dropTableWithForeignKeys('wiki_page');
        $this->dropTableWithForeignKeys('wiki_page_revision');
        $this->dropTableWithForeignKeys('wiki_link');
    }
}