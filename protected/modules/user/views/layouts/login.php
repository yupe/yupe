<?php
/**
 * Отображение для layouts/main:
 *
 *   @category YupeLayout
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CHtml::encode(Yii::app()->name); ?> <?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php
    $mainAssets = Yii::app()->assetManager->publish(
        Yii::getPathOfAlias('application.modules.yupe.views.assets')
    );
    Yii::app()->clientScript->registerCssFile($mainAssets . '/css/styles.css');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/main.js');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/jquery.li-translit.js');
    if (($langs = $this->yupe->languageSelectorArray) != array())
        Yii::app()->clientScript->registerCssFile($mainAssets. '/css/flags.css');
    ?>
    <link rel="shortcut icon" href="<?php echo $mainAssets; ?>/img/favicon.ico"/>

</head>

<body>
<div id="overall-wrap">
    <!-- mainmenu -->
    <?php  $brandTitle = Yii::t('UserModule.user', 'Control panel'); ?>
    <?php
            $this->widget(
                'bootstrap.widgets.TbNavbar', array(
                    'htmlOptions' => array('class' => 'navbar-inverse'),
                    'fluid'       => true,
                    'brand'       => CHtml::image(
                        Yii::app()->baseUrl . "/web/images/logo.png", Yii::app()->name, array(
                            'width'  => '38',
                            'height' => '38',
                            'title'  => Yii::app()->name,
                        )
                    ),
                    'brandUrl'    => CHtml::normalizeUrl(array("/yupe/backend/index")),
                    'items'       => array(
                        array(
                            'class'       => 'bootstrap.widgets.TbMenu',
                            'htmlOptions' => array('class' => 'pull-right'),
                            'encodeLabel' => false,
                            'items'       => array_merge(
                                array(
                                    array(
                                        'icon'  => 'question-sign white',
                                        'label' => Yii::t('UserModule.user', 'Help'),
                                        'url'   => 'http://yupe.ru/docs/index.html?from=login',
                                        'items' => array(
                                            array(
                                                'icon'  => 'icon-globe',
                                                'label' => Yii::t('UserModule.user', 'Official site'),
                                                'url'   => 'http://yupe.ru?from=help',
                                                'linkOptions' => array('target' => '_blank'),
                                            ),
                                            array(
                                                'icon'  => 'icon-book',
                                                'label' => Yii::t('UserModule.user', 'Official documentation'),
                                                'url'   => 'http://yupe.ru/docs/index.html?from=login',
                                                'linkOptions' => array('target' => '_blank'),
                                            ),
                                            array(
                                                'icon'  => 'icon-th-large',
                                                'label' => Yii::t('UserModule.user', 'Additional modules'),
                                                'url'   => 'https://github.com/yupe/yupe-ext',
                                                'linkOptions' => array('target' => '_blank'),
                                            ),
                                            array(
                                                'icon'  => 'icon-comment',
                                                'label' => Yii::t('UserModule.user', 'Forum'),
                                                'url'   => 'http://yupe.ru/talk/?from=login',
                                                'linkOptions' => array('target' => '_blank'),
                                            ),
                                            array(
                                                'icon'  => 'icon-globe',
                                                'label' => Yii::t('UserModule.user', 'Community in GitHub'),
                                                'url'   => 'https://github.com/yupe/yupe',
                                                'linkOptions' => array('target' => '_blank'),
                                            ),
                                            array(
                                                'icon'  => 'icon-thumbs-up',
                                                'label' => Yii::t('UserModule.user', 'Order development and support'),
                                                'url'   => 'http://yupe.ru/contacts?from=login',
                                                'linkOptions' => array('target' => '_blank'),
                                            ),
                                            array(
                                                'icon'  => 'icon-warning-sign',
                                                'label' => Yii::t('UserModule.user', 'Report error'),
                                                'url'   => 'http://yupe.ru/contacts?from=login',
                                                'linkOptions' => array('target' => '_blank'),
                                            ),
                                            array(
                                                'icon'  => 'exclamation-sign',
                                                'label' => Yii::t('UserModule.user', 'About Yupe!'),
                                                'url'   => 'http://yupe.ru/pages/about?from=login',
                                                'linkOptions' => array('target' => '_blank'),
                                            ),
                                        )
                                    ),
                                    array(
                                        'icon'        => 'home white',
                                        'label'       => Yii::t('UserModule.user', 'Go home'),
                                        'linkOptions' => array('target' => '_blank'),
                                        'url'         => array('/' . Yii::app()->defaultController . '/index/'),
                                    ),
                                ), $this->yupe->languageSelectorArray
                            ),
                        ),
                    ),
                )
            ); ?>
    <div class="container-fluid" id="page">
        <?php echo $content; ?>
        <div id="footer-guard"><!-- --></div>
    </div>
</div>

<footer>
    Copyright &copy; 2009-<?php echo date('Y'); ?>
    <?php echo $this->yupe->poweredBy();?>
    <br/>
    <a href="http://amylabs.ru/?from=yupe-panel">
        <?php echo Yii::t('UserModule.user', 'Development and support'); ?></a> - <a href="http://amylabs.ru/?from=yupe-panel" target="_blank">amyLabs
    </a>
</footer>

</body>
</html>