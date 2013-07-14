<?php
/**
* Converter to migrating existing comments
* from Adjacency List to Nested Sets.
*
* @category YupeConsoleCommand
* @package  YupeCMS
* @author   YupeTeam <team@yupe.ru>
* @author   Anton Kucherov <idexter.ru@gmail.com>
* @link     http://yupe.ru
*/
class YCommentsALtoNsCommand extends CConsoleCommand
{
    const NS_MIGRATION_NAME = 'm130704_095200_comment_nestedsets';

    public function actionIndex()
    {
        $this->checkForNestedSetsMigration();
    }

    private function checkForNestedSetsMigration()
    {
        $migrator = new Migrator();
        $history = $migrator->getMigrationHistory('comment');
        if(array_key_exists(self::NS_MIGRATION_NAME,$history)){
            echo "Checking for '".self::NS_MIGRATION_NAME."' migration -> [OK]\n";
        }else{
            echo "Checking for '".self::NS_MIGRATION_NAME."' migration -> [FAILED]\n";
            Yii::app()->end();
        }
    }
}