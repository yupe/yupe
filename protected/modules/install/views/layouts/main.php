<?php
/**
 * Шаблон инсталятора:
 *
 * @category YupeLayouts
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl; ?>/favicon.ico">
    <title>
        <?php echo CHtml::encode(Yii::app()->name) . ' ' . CHtml::encode($this->pageTitle); ?>
    </title>
    <?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    $yupeAssets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.modules.yupe.views.assets'));
    $installAssets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.modules.install.views.assets'));
    Yii::app()->clientScript->registerCssFile($yupeAssets . '/css/styles.css');
    Yii::app()->clientScript->registerCssFile($yupeAssets . '/css/flags.css');
    Yii::app()->clientScript->registerCssFile($installAssets . '/css/install.css');
    ?>
</head>
<body>
<div id="overall-wrap">
    <?php
    $brandTitle = Yii::t('InstallModule.install', 'Install') . ' ' . CHtml::encode(Yii::app()->name);
    $this->widget(
        'bootstrap.widgets.TbNavbar',
        array(
            'fluid' => true,
            'brand' => CHtml::image(
                Yii::app()->baseUrl . "/web/images/logo.png",
                $brandTitle,
                array(
                    'width' => '38',
                    'height' => '38',
                    'title' => $brandTitle,
                )
            ),
            'brandUrl' => $this->createUrl('index'),
            'items' => array(
                CHtml::tag('span', array('id' => 'stepName'), CHtml::encode($this->stepName)),
                array(
                    'class' => 'bootstrap.widgets.TbMenu',
                    'type' => 'navbar',
                    'htmlOptions' => array('class' => 'navbar-right'),
                    'items' => array_merge(
                        array(
                            array(
                                'icon' => 'glyphicon glyphicon-question-sign',
                                'label' => Yii::t('YupeModule.yupe', 'Help'),
                                'url' => 'http://yupe.ru/docs/index.html?from=install',
                                'items' => array(
                                    array(
                                        'icon' => 'glyphicon glyphicon-globe',
                                        'label' => Yii::t('YupeModule.yupe', 'Official site'),
                                        'url' => 'http://yupe.ru?from=install',
                                        'linkOptions' => array('target' => '_blank'),
                                    ),
                                    array(
                                        'icon' => 'glyphicon glyphicon-book',
                                        'label' => Yii::t('YupeModule.yupe', 'Official docs'),
                                        'url' => 'http://yupe.ru/docs/index.html?from=install',
                                        'linkOptions' => array('target' => '_blank'),
                                    ),
                                    array(
                                        'icon' => 'glyphicon glyphicon-th-large',
                                        'label' => Yii::t('YupeModule.yupe', 'Additional modules'),
                                        'url' => 'https://github.com/yupe/yupe-ext',
                                        'linkOptions' => array('target' => '_blank'),
                                    ),
                                    array(
                                        'icon' => 'glyphicon glyphicon-comment',
                                        'label' => Yii::t('YupeModule.yupe', 'Forum'),
                                        'url' => 'http://yupe.ru/talk/?from=install',
                                        'linkOptions' => array('target' => '_blank'),
                                    ),
                                    array(
                                        'icon' => 'glyphicon glyphicon-globe',
                                        'label' => Yii::t('YupeModule.yupe', 'Community on github'),
                                        'url' => 'https://github.com/yupe/yupe',
                                        'linkOptions' => array('target' => '_blank'),
                                    ),
                                    array(
                                        'icon' => 'glyphicon glyphicon-thumbs-up',
                                        'label' => Yii::t('YupeModule.yupe', 'Order development and/or support'),
                                        'url' => 'http://amylabs.ru/contact?from=install',
                                        'linkOptions' => array('target' => '_blank'),
                                    ),
                                    array(
                                        'icon' => 'glyphicon glyphicon-warning-sign',
                                        'label' => Yii::t('YupeModule.yupe', 'Report bug'),
                                        'url' => 'http://yupe.ru/contacts?from=install',
                                        'linkOptions' => array('target' => '_blank'),
                                    ),
                                    array(
                                        'icon' => 'glyphicon glyphicon-exclamation-sign',
                                        'label' => Yii::t('YupeModule.yupe', 'About Yupe!'),
                                        'url' => 'http://yupe.ru/pages/about?from=install',
                                        'linkOptions' => array('target' => '_blank'),
                                    ),
                                ),
                            ),
                            array(
                                'label' => $this->yupe->getVersion(),
                                'icon' => 'glyphicon glyphicon-thumbs-up',
                                'url' => 'http://yupe.ru/?from=install'
                            ),
                        ),
                        $this->yupe->getLanguageSelectorArray()
                    ),
                ),
            ),
        )
    );
    ?>

    <div class='installContentWrapper'>
        <?php if (count($this->breadcrumbs)) {
            $this->widget('bootstrap.widgets.TbBreadcrumbs', array('links' => $this->breadcrumbs));
        }
        ?>
        <!-- breadcrumbs -->
        <?php //$this->widget('yupe\widgets\YFlashMessages'); ?>
        <div class="installContent row">
            <?php echo $content; ?>
        </div>
        <!-- content -->
    </div>
</div>
<footer>
    Copyright &copy; 2010-<?php echo date('Y'); ?>
    <?php echo $this->yupe->poweredBy(); ?>
    <small class="label label-info"><?php echo $this->yupe->getVersion(); ?></small>
    <br/>
    <a href="http://amylabs.ru/?from=install" target="_blank">
        <?php echo Yii::t('YupeModule.yupe', 'Development and support'); ?></a> - <a href="http://amylabs.ru/?from=yupe-install" target="_blank">amyLabs</a>
    <br/>
    <?php echo Yii::powered(); ?>
</footer>
<!-- footer -->
</body>
</html>