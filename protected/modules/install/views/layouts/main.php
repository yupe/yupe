<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CHtml::encode(Yii::app()->name); ?> <?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php if (!$this->yupe->enableAssets): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $this->yupe->themeBaseUrl; ?>/web/booster-install/assets/css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $this->yupe->themeBaseUrl; ?>/web/booster-install/assets/js/bootstrap.min.js"/>
    <?php endif; ?>
    <?php if (($langs = $this->yupe->languageSelectorArray) != array()): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $this->yupe->themeBaseUrl; ?>/css/flags.css"/>
    <?php endif; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->yupe->themeBaseUrl; ?>/css/styles.css"/>
</head>
<body>
<div id="overall-wrap">
    <?php
    $brandTitle = Yii::t('InstallModule.install', 'Установка') . ' ' . CHtml::encode(Yii::app()->name);
    $this->widget('bootstrap.widgets.TbNavbar', array(
        'htmlOptions' => array('class'=>'navbar navbar-inverse'),
        'fluid' => true,
        'brand' => CHtml::image($this->yupe->themeBaseUrl . "/images/logo.png", $brandTitle, array(
            'width'  => '38',
            'height' => '38',
            'title'  => $brandTitle,
        )),
        'brandUrl' => CHtml::normalizeUrl(array("/install")),
        'items' => array(
            '<div style="float: left; font-size: 19px; margin-top: 12px;">' . CHtml::encode($this->stepName) . '</div>',
            array(
                'class' => 'bootstrap.widgets.TbMenu',
                'htmlOptions' => array('class' => 'pull-right'),
                'items' => array(
                    array(
                        'icon' => 'question-sign white',
                        'label' => Yii::t('InstallModule.install', 'Необходима помощь?'),
                        'url' => 'http://yupe.ru/feedback/contact?from=install',
                        'target' => '_blank',
                    ),
                    array(
                        'label' => $this->yupe->version,
                        'icon'  => 'icon-thumbs-up icon-white',
                        'url'   => 'http://yupe.ru/?from=navbar'
                    ),
                    $this->yupe->languageSelectorArray,
                ),
            ),
        ),
    ));
    ?>
    <div class='row-fluid'>
        <?php if (count($this->breadcrumbs))
            $this->widget('bootstrap.widgets.TbBreadcrumbs', array('links' => $this->breadcrumbs));
        ?><!-- breadcrumbs -->
        <?php $this->widget('YFlashMessages'); ?>
        <div id="content">
            <?php echo $content; ?>
        </div>
        <!-- content -->
    </div>
    <div id="footer-guard"><!-- --></div>
</div>
<footer>
    Copyright &copy; 2009-<?php echo date('Y'); ?> <?php echo CHtml::link(Yii::t('yupe','Юпи!'), 'http://yupe.ru/?from=install'); ?><br/>
    <?php echo Yii::powered(); ?>
</footer><!-- footer -->
</body>
</html>