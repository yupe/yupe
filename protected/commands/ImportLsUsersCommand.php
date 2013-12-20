<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aopeykin
 * Date: 20.12.13
 * Time: 9:52
 * To change this template use File | Settings | File Templates.
 */

class ImportLsUsersCommand extends CConsoleCommand
{
    public function run()
    {
        $userFile = __DIR__.DIRECTORY_SEPARATOR.ls.DIRECTORY_SEPARATOR.'user.php';

        if(false === file_exists($userFile)) {
            die('No user file!');
        }
    }
}