<?php
return array_merge(
    require(dirname(__FILE__) . '/main.php'),
    array(
        'import' => array(
            'application.components.*',
            'application.models.*',
            'application.modules.yupe.models.*',
            'application.modules.yupe.components.*',
            'application.modules.yupe.controllers.*',
            'application.modules.yupe.components.controllers.*',
            'application.modules.yupe.extensions.tagcache.*',
            'application.modules.yupe.widgets.*',
        ),
        'components'    => array(
            'bootstrap' => array(
                'class' => 'bootstrap.components.Bootstrap',
                'responsiveCss'  => true,
                'fontAwesomeCss' => true,
            ),
            // Работа с миграциями, обновление БД модулей
            'migrator'=>array(
                'class'=>'application.modules.yupe.components.migrator.Migrator',
            ),
            'themeManager'       => array(
                'basePath'       => dirname(__DIR__) . '/../themes',
            ),
            'db'        => require dirname(__FILE__) . '/db-test.php',
            'cache'     => array(
                'class' => 'CFileCache',
                'behaviors' => array(
                    'clear' => array(
                        'class' => 'application.modules.yupe.extensions.tagcache.TaggingCacheBehavior',
                    ),
                ),
            ),
            'fixture'    => array(
                'class'  => 'system.test.CDbFixtureManager',
            ),
            'urlManager' => array(
                'class'          => 'application.modules.yupe.components.urlManager.LangUrlManager',
                'languageInPath' => true,
                'langParam'      => 'language',
                'urlFormat'      => 'path',
                'showScriptName' => true
            )
        ),
    )
);
