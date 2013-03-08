<?php
class YDbMigration extends CDbMigration
{
    public function getOptions()
    {
    	return Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
    }
}
