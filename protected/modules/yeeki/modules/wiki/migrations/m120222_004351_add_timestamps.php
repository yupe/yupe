<?php
class m120222_004351_add_timestamps extends CDbMigration
{
	public function up()
	{
		$this->addColumn('wiki_page', 'created_at', 'integer');
		$this->addColumn('wiki_page', 'updated_at', 'integer');
		$this->addColumn('wiki_page_revision', 'created_at', 'integer');
	}

	public function down()
	{
		$this->dropColumn('wiki_page', 'created_at');
		$this->dropColumn('wiki_page', 'updated_at');
		$this->dropColumn('wiki_page_revision', 'created_at');
	}
}