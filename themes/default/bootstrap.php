<?php
/**
 * Theme bootstrap file.
 */

// We need to do this to ensure that assets was published even if we don't use any booster widget on the page
if (Yii::app()->hasComponent('bootstrap')) {
    Yii::app()->getComponent('bootstrap');
}
// Get clientScript component
$clientScript = Yii::app()->getClientScript();

// Get assetManager component
$assetManager = Yii::app()->getAssetManager();

// Publish theme assets, note that we keep assets in web folder
$assetPath = $assetManager->publish(
    Yii::app()->theme->basePath . '/web'
);

// Styles
$styles = array(
    'main.css',
    'flags.css'
);

foreach ($styles as $style) {
    $clientScript->registerCssFile($assetPath . '/css/' . $style);
}

// Javascript
$scripts = array( // for example
    //'theme.js' => CClientScript::POS_END
);

foreach ($scripts as $script => $position) {
    $clientScript->registerScriptFile($assetPath . '/js/' . $script, $position);
}


$clientScript->registerScript('baseUrl', "var baseUrl = '" . Yii::app()->getBaseUrl() . "'", CClientScript::POS_HEAD);

// Favicon
$clientScript->registerLinkTag('shortcut icon', null, $assetPath . '/images/favicon.ico');