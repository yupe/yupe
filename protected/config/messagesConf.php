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
        'yiilite.php',
        'yiit.php',
        'dbConfFile.php',
        'DefaultController.php',
        '/i18n/data',
        '/messages',
        '/vendors',
        '/web/js',
        '/protected/config',
        '/protected/modules',
        '/protected/modules/install/views/default/dbsettings.php'
    ),
);