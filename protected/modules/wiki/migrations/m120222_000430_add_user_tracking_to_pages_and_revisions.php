<?php

class m120222_000430_add_user_tracking_to_pages_and_revisions extends CDbMigration
{
	public function up()
	{
		$this->addColumn('wiki_page', 'user_id', 'string');
		$this->addColumn('wiki_page_revision', 'user_id', 'string');
	}

	public function down()
	{
		$this->dropColumn('wiki_page', 'user_id');
		$this->dropColumn('wiki_page_revision', 'user_id');
	}
}