<?php
return array_merge(
    require(dirname(__FILE__) . '/main.php'),
    array(
        'import' => array(
            'application.components.*',
            'application.models.*',
            'application.modules.yupe.models.*',
            'application.modules.yupe.extensions.tagcache.*',
        ),
        'components'    => array(
            'db'        => require dirname(__FILE__) . '/db-test.php',
            'cache'     => array(   
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
