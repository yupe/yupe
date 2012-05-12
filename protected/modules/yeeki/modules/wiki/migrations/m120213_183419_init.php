<?php
/**
 * Initial application schema
 */
class m120213_183419_init extends CDbMigration
{
	public function up()
	{
		// SHOW VARIABLES LIKE 'have_innodb'

		$this->createTable('wiki_page', array(
			'id' => 'pk',
			'is_redirect' => 'boolean DEFAULT 0',
			'page_uid' => 'string',
			'namespace' => 'string',
			'content' => 'text',
			'revision_id' => 'integer',
		), 'ENGINE=InnoDB');

		$this->createIndex('wiki_idx_page_namespace', 'wiki_page', 'namespace');
		$this->createIndex('wiki_idx_page_page_uid', 'wiki_page', 'page_uid', true);
		$this->createIndex('wiki_idx_page_revision_id', 'wiki_page', 'revision_id', true);

		$this->createTable('wiki_page_revision', array(
			'id' => 'pk',
			'page_id' => 'integer NOT NULL',
			'comment' => 'string',
			'is_minor' => 'boolean',
			'content' => 'text',
		), 'ENGINE=InnoDB');

		$this->addForeignKey('wiki_fk_page_revision_page', 'wiki_page_revision', 'page_id', 'wiki_page', 'id', 'CASCADE');

		$this->createTable('wiki_link', array(
			'id' => 'pk',
			'page_from_id' => 'integer NOT NULL',
			'page_to_id' => 'integer',
			'wiki_uid' => 'string',
			'title' => 'string',
		), 'ENGINE=InnoDB');

		$this->addForeignKey('wiki_fk_link_page_from', 'wiki_link', 'page_from_id', 'wiki_page', 'id', 'CASCADE');
		$this->addForeignKey('wiki_fk_link_page_to', 'wiki_link', 'page_to_id', 'wiki_page', 'id', 'SET NULL');
	}

	public function down()
	{
		$this->dropForeignKey('wiki_fk_link_page_from', 'wiki_link');
		$this->dropForeignKey('wiki_fk_link_page_to', 'wiki_link');
		$this->dropForeignKey('wiki_fk_page_revision_page', 'wiki_page_revision');

		$this->dropTable('wiki_page');
		$this->dropTable('wiki_page_revision');
		$this->dropTable('wiki_link');
	}
}