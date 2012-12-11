<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
        $module = Yii::app()->getModule('yupe');
        $webPath = Yii::app()->assetManager->publish($module->basePath . '/web/');
        Yii::app()->clientScript->registerScriptFile($webPath . '/yupeAdmin.js');
    ?>

    <title><?php echo CHtml::encode(Yii::app()->name); ?> <?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel="stylesheet" type="text/css"  href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css"/>
</head>

<body>

<div id="overall-wrap">

    <?php
    $brandTitle = Yii::t('install', 'Установка') . ' ' . CHtml::encode(Yii::app()->name);

    $this->widget('bootstrap.widgets.TbNavbar', array(
        'htmlOptions' => array('class'=>'navbar navbar-inverse'),
        'fluid' => true,
        'brand' => CHtml::image(Yii::app()->theme->baseUrl . "/images/logo.png", $brandTitle, array(
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
                        'label' => Yii::t('install', 'Необходима помощь?'),
                        'url' => 'http://yupe.ru/feedback/contact?from=install',
                        'target' => '_blank',
                    ),
                    array(
                        'label' => $this->yupe->getVersion(),
                        'icon'  => 'icon-thumbs-up icon-white',
                        'url'   => 'http://yupe.ru/?from=navbar'
                    ),
                ),
            ),
        ),
    ));
    ?>

    <div class="container" id="page">
        <div class="row"> 
            <div class="span8 offset2 well">
                <?php
                if (count($this->breadcrumbs))
                    $this->widget('bootstrap.widgets.TbBreadcrumbs', array('links' => $this->breadcrumbs));
                ?><!-- breadcrumbs -->
                <?php $this->widget('YFlashMessages');?>

                <div id="content">
                    <?php echo $content; ?>
                </div>
                <!-- content -->
            </div>
        </div> 
    </div>
    <div id="footer-guard"><!-- --></div>
</div>
<footer>
    Copyright &copy; 2009-<?php echo date('Y'); ?> <?php echo CHtml::link('Юпи!', 'http://yupe.ru/'); ?><br/>
    <?php echo Yii::powered(); ?>
</body><!-- footer -->

</html>
