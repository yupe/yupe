<?php
/**
 * Theme bootstrap file.
 */
Yii::app()->getClientScript()->registerScript('baseUrl', "var baseUrl = '" . Yii::app()->getBaseUrl() . "'", CClientScript::POS_HEAD);

// Favicon
Yii::app()->getClientScript()->registerLinkTag('shortcut icon', null, Yii::app()->getTheme()->getAssetsUrl() . '/images/favicon.ico');

Yii::import('themes.'.Yii::app()->theme->name.'.ShopThemeEvents');
