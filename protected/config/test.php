<?php

return CMap::mergeArray(
    require(dirname(__FILE__) . '/main.php'),
    array(
         'components' => array(
             'fixture' => array(
                 'class' => 'system.test.CDbFixtureManager',
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
