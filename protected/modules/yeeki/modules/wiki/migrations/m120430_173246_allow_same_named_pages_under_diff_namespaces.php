<?php
class m120430_173246_allow_same_named_pages_under_diff_namespaces extends CDbMigration
{
	public function up()
	{
		$this->dropIndex('wiki_idx_page_page_uid', 'wiki_page');
		$this->createIndex('wiki_idx_page_page_uid', 'wiki_page', 'page_uid, namespace', true);
	}

	public function down()
	{
		$this->dropIndex('wiki_idx_page_page_uid', 'wiki_page');
		$this->createIndex('wiki_idx_page_page_uid', 'wiki_page', 'page_uid', true);
	}
}