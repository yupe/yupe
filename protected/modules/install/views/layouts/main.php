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
    // bootstrap v2.3.2 css
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/web/install/css/bootstrap.min.css');
    // стили из админки
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/web/css/styles.css');
    // стили инсталятора
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/web/install/css/install.css');
    // bootstrap v2.3.2 js
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/web/install/js/bootstrap.min.js', CClientScript::POS_END);
    // jquery v1.8.3
    ?>

    <?php if (!$this->yupe->enableAssets):?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/web/install/js/jquery.min.js');?>
        <?php $mainAssets = Yii::app()->baseUrl . '/web/'; ?>
    <?php else: ?>
        <?php Yii::app()->clientScript->registerCoreScript('jquery');?>
        <?php $mainAssets = Yii::app()->assetManager->publish(
            Yii::getPathOfAlias('application.modules.yupe.views.assets')
        );?>
    <?php endif;?>

    <?php Yii::app()->clientScript->registerCssFile($mainAssets. '/css/flags.css');?>
</head>
<body>
<div id="overall-wrap">
    <?php
    $brandTitle = Yii::t('InstallModule.install', 'Install') . ' ' . CHtml::encode(Yii::app()->name);
    $this->widget(
        'bootstrap.widgets.TbNavbar',
        array(
            'htmlOptions' => array('class' => 'navbar navbar-inverse'),
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
                    'htmlOptions' => array('class' => 'pull-right'),
                    'items' => array_merge(array(
                        array(
                            'icon'  => 'question-sign white',
                            'label' => Yii::t('YupeModule.yupe', 'Help'),
                            'url'   => 'http://yupe.ru/docs/index.html?from=install',
                            'items' => array(
                                array(
                                    'icon'  => 'icon-globe',
                                    'label' => Yii::t('YupeModule.yupe', 'Official site'),
                                    'url'   => 'http://yupe.ru?from=install',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'icon-book',
                                    'label' => Yii::t('YupeModule.yupe', 'Official docs'),
                                    'url'   => 'http://yupe.ru/docs/index.html?from=install',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'icon-th-large',
                                    'label' => Yii::t('YupeModule.yupe', 'Additional modules'),
                                    'url'   => 'https://github.com/yupe/yupe-ext',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'icon-comment',
                                    'label' => Yii::t('YupeModule.yupe', 'Forum'),
                                    'url'   => 'http://yupe.ru/talk/?from=install',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'icon-globe',
                                    'label' => Yii::t('YupeModule.yupe', 'Community on github'),
                                    'url'   => 'https://github.com/yupe/yupe',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'icon-thumbs-up',
                                    'label' => Yii::t('YupeModule.yupe', 'Order development and/or support'),
                                    'url'   => 'http://amylabs.ru/contact?from=install',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'icon-warning-sign',
                                    'label' => Yii::t('YupeModule.yupe', 'Report bug'),
                                    'url'   => 'http://yupe.ru/contacts?from=install',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'exclamation-sign',
                                    'label' => Yii::t('YupeModule.yupe', 'About Yupe!'),
                                    'url'   => 'http://yupe.ru/pages/about?from=install',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                            ),
                        ),
                        array(
                            'label' => $this->yupe->getVersion(),
                            'icon' => 'icon-thumbs-up icon-white',
                            'url' => 'http://yupe.ru/?from=install'
                        ),
                      ), $this->yupe->getLanguageSelectorArray()
                    ),
                ),
            ),
        )
    );
    ?>

    <div class='row-fluid installContentWrapper'>
        <?php if (count($this->breadcrumbs))
            $this->widget('bootstrap.widgets.TbBreadcrumbs', array('links' => $this->breadcrumbs));
        ?>
        <!-- breadcrumbs -->
        <?php //$this->widget('yupe\widgets\YFlashMessages'); ?>
        <div class="installContent">
            <?php echo $content; ?>
        </div>
        <!-- content -->
    </div>
</div>
<footer>
    Copyright &copy; 2009-<?php echo date('Y'); ?>
    <?php echo $this->yupe->poweredBy();?>
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