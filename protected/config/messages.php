<?php
/**
 * This is the configuration for generating message translations
 * for the Yii framework. It is used by the 'yiic message' command.
 */
return array(
    'sourcePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'messagePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'messages',
    'languages' => array('en'),
    'fileTypes' => array('php'),
    'exclude' => array(
        '.svn',
        '.git',
        'yiilite.php',
        'yiit.php',        
        '/messages',        
        '/web/js',
        '/config',        
        '/modules/yupe/extensions/yupe/gii/',        
        '/commands/',
        '../themes/backend_bootstrap/extensions/'
    ),
);