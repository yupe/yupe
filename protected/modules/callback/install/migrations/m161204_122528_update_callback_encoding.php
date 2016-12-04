<?php

class m161204_122528_update_callback_encoding extends yupe\components\DbMigration
{
	public function safeUp()
	{
        Yii::app()->getDb()->createCommand('ALTER TABLE {{callback}} CONVERT TO CHARACTER SET utf8, COLLATE utf8_general_ci')->execute();
	}
}