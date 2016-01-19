<?php

class m160119_084800_rename_yandex_market_table extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->renameTable('{{yandex_market_export}}','{{yml_export}}');

	}

	public function safeDown()
	{
		$this->renameTable('{{yml_export}}', '{{yandex_market_export}}');
	}
}