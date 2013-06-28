<?php
/**
 * Отображение для layouts/main:
 *
 *   @category YupeLayout
 *   @package  YupeCMS
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
    <?php  $brandTitle = Yii::t('YupeModule.yupe', 'Перейти на главную панели управления'); ?>
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
                                        'label' => Yii::t('YupeModule.yupe', 'Помощь'),
                                        'url'   => 'http://yupe.ru/docs/index.html?from=login',
                                        'items' => array(
                                            array(
                                                'icon'  => 'icon-globe',
                                                'label' => Yii::t('YupeModule.yupe', 'Официальный сайт'),
                                                'url'   => 'http://yupe.ru?from=help',
                                                'linkOptions' => array('target' => '_blank'),
                                            ),
                                            array(
                                                'icon'  => 'icon-book',
                                                'label' => Yii::t('YupeModule.yupe', 'Официальная документация'),
                                                'url'   => 'http://yupe.ru/docs/index.html?from=login',
                                                'linkOptions' => array('target' => '_blank'),
                                            ),
                                            array(
                                                'icon'  => 'icon-th-large',
                                                'label' => Yii::t('YupeModule.yupe', 'Дополнительные модули'),
                                                'url'   => 'https://github.com/yupe/yupe-ext',
                                                'linkOptions' => array('target' => '_blank'),
                                            ),
                                            array(
                                                'icon'  => 'icon-comment',
                                                'label' => Yii::t('YupeModule.yupe', 'Форум'),
                                                'url'   => 'http://yupe.ru/talk/?from=login',
                                                'linkOptions' => array('target' => '_blank'),
                                            ),
                                            array(
                                                'icon'  => 'icon-globe',
                                                'label' => Yii::t('YupeModule.yupe', 'Сообщество на github'),
                                                'url'   => 'https://github.com/yupe/yupe',
                                                'linkOptions' => array('target' => '_blank'),
                                            ),
                                            array(
                                                'icon'  => 'icon-thumbs-up',
                                                'label' => Yii::t('YupeModule.yupe', 'Заказать разработку или поддержку'),
                                                'url'   => 'http://yupe.ru/feedback/index?from=login',
                                                'linkOptions' => array('target' => '_blank'),
                                            ),
                                            array(
                                                'icon'  => 'icon-warning-sign',
                                                'label' => Yii::t('YupeModule.yupe', 'Сообщить об ошибке'),
                                                'url'   => 'http://yupe.ru/feedback/index?from=login',
                                                'linkOptions' => array('target' => '_blank'),
                                            ),
                                            array(
                                                'icon'  => 'exclamation-sign',
                                                'label' => Yii::t('YupeModule.yupe', 'О Юпи!'),
                                                'url'   => 'http://yupe.ru/pages/about?from=login',
                                                'linkOptions' => array('target' => '_blank'),
                                            ),
                                        )
                                    ),
                                    array(
                                        'icon'        => 'home white',
                                        'label'       => Yii::t('YupeModule.yupe', 'На сайт'),
                                        'linkOptions' => array('target' => '_blank'),
                                        'url'         => array('/' . Yii::app()->defaultController . '/index/'),
                                    ),
                                ), $this->yupe->languageSelectorArray
                            ),
                        ),
                    ),
                )
            ); ?>
    <div class="container-fluid" id="page"><?php echo $content; ?></div>
    <div id="footer-guard"><!-- --></div>
</div>

<footer>
    Copyright &copy; 2009-<?php echo date('Y'); ?>
    <?php echo $this->yupe->poweredBy();?>
    <br/>
    <a href="http://amylabs.ru/?from=yupe-panel">
        <?php echo Yii::t('YupeModule.yupe', 'Разработка и поддержка'); ?></a> - <a href="http://amylabs.ru/?from=yupe-panel" target="_blank">amyLabs
    </a>
</footer>

</body>
</html>