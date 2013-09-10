<?php

return CMap::mergeArray(
    require(dirname(__FILE__) . '/main.php'),
    array(
        'import'         => array(
            'application.modules.yupe.models.*',
            'application.modules.yupe.extensions.tagcache.*',
        ),
        'components'     => array(
            'db'         => require dirname(__FILE__) . '/db.php',
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
