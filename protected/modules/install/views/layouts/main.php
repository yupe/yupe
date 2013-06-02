<?php
/**
 * Шаблон инсталятора:
 *
 * @category YupeLayouts
 * @package  YupeCMS
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
    if (!$this->yupe->enableAssets)
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/web/install/js/jquery.min.js');
    else
        Yii::app()->clientScript->registerCoreScript('jquery');
    ?>
</head>
<body>
<div id="overall-wrap">
    <?php
    $brandTitle = Yii::t('InstallModule.install', 'Установка') . ' ' . CHtml::encode(Yii::app()->name);
    $this->widget(
        'bootstrap.widgets.TbNavbar',
        array(
            'htmlOptions' => array('class' => 'navbar navbar-inverse'),
            'fluid' => true,
            'brand' => CHtml::image(
                $this->yupe->themeBaseUrl . "/web/images/logo.png",
                $brandTitle,
                array(
                    'width' => '38',
                    'height' => '38',
                    'title' => $brandTitle,
                )
            ),
            'brandUrl' => $this->createUrl('index'),
            'items' => array(
                CHtml::tag('span', array('id' => 'stepName'),  CHtml::encode(
                    $this->stepName)),

                array(
                    'class' => 'bootstrap.widgets.TbMenu',
                    'htmlOptions' => array('class' => 'pull-right'),
                    'items' => array(
                        array(
                            'icon' => 'question-sign white',
                            'label' => Yii::t('InstallModule.install', 'Документация'),
                            'url' => 'http://yupe.ru/docs/index.html?from=install',
                            'linkOptions' => array('target' => '_blank'),
                        ),
                        array(
                            'icon' => 'question-sign white',
                            'label' => Yii::t('InstallModule.install', 'Необходима помощь?'),
                            'url' => 'http://yupe.ru/feedback/index?from=install',
                            'linkOptions' => array('target' => '_blank'),
                        ),
                        array(
                            'label' => $this->yupe->version,
                            'icon' => 'icon-thumbs-up icon-white',
                            'url' => 'http://yupe.ru/?from=navbar'
                        ),
                        $this->yupe->languageSelectorArray,
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
        <?php $this->widget('YFlashMessages'); ?>
        <div class="installContent">
            <?php echo $content; ?>
        </div>
        <!-- content -->
    </div>
</div>
<footer>
    Copyright &copy; 2009-<?php echo date('Y'); ?> <?php echo CHtml::link(
        Yii::t('install', 'Юпи!'),
        'http://yupe.ru/?from=install'
    ); ?><br/>
    <?php echo Yii::powered(); ?>
</footer>
<!-- footer -->
</body>
</html>