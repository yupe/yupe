<?php
/**
 * Шаблон инсталятора:
 * 
 *   @category YupeLayouts
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?php echo Yii::app()->baseUrl;?>/web/images/favicon.png" />
<?php
echo '<title>' . CHtml::encode(Yii::app()->name). ' ' . CHtml::encode($this->pageTitle) . '</title>';
if (!$this->yupe->enableAssets) {
    Yii::app()->clientScript->registerScriptFile($this->yupe->themeBaseUrl . '/web/jquery-install/jquery.min.js');
    Yii::app()->clientScript->registerCssFile($this->yupe->themeBaseUrl . '/web/booster-install/assets/css/bootstrap.css');
    Yii::app()->clientScript->registerScriptFile($this->yupe->themeBaseUrl . '/web/booster-install/assets/js/bootstrap.min.js');
} else {
    Yii::app()->clientScript->registerCoreScript('jquery');
}
if (($langs = $this->yupe->languageSelectorArray) != array())
    Yii::app()->clientScript->registerCssFile($this->yupe->themeBaseUrl . '/web/css/flags.css');
Yii::app()->clientScript->registerCssFile($this->yupe->themeBaseUrl . '/web/css/styles.css');
Yii::app()->clientScript->registerCssFile($this->yupe->themeBaseUrl . '/web/css/install.css');
?>
</head>
<body>
<div id="overall-wrap">
    <?php
    $brandTitle = Yii::t('InstallModule.install', 'Установка') . ' ' . CHtml::encode(Yii::app()->name);
    $this->widget(
        'bootstrap.widgets.TbNavbar', array(
            'htmlOptions' => array('class'=>'navbar navbar-inverse'),
            'fluid' => true,
            'brand' => CHtml::image(
                $this->yupe->themeBaseUrl . "/web/images/logo.png", $brandTitle, array(
                    'width'  => '38',
                    'height' => '38',
                    'title'  => $brandTitle,
                )
            ),
            'brandUrl' => $this->createUrl('index'),
            'items' => array(
                '<div style="float: left; font-size: 19px; margin-top: 12px;">' . CHtml::encode($this->stepName) . '</div>',
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
                            'icon'  => 'icon-thumbs-up icon-white',
                            'url'   => 'http://yupe.ru/?from=navbar'
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
        ?><!-- breadcrumbs -->
        <?php $this->widget('YFlashMessages'); ?>
        <div class="installContent">
            <?php echo $content; ?>
        </div>
        <!-- content -->
    </div>
</div>
<footer>
    Copyright &copy; 2009-<?php echo date('Y'); ?> <?php echo CHtml::link(Yii::t('install', 'Юпи!'), 'http://yupe.ru/?from=install'); ?><br/>
    <?php echo Yii::powered(); ?>
</footer><!-- footer -->
</body>
</html>