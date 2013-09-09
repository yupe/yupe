<?php
/**
 * Отображение для layouts/main:
 *
 *   @category YupeLayout
 *   @package  YupeCMS
 *   @author   Yupe Team <team@engine.ru>
 *   @license  https://github.com/engine/engine/blob/master/LICENSE BSD
 *   @link     http://engine.ru
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
        Yii::getPathOfAlias('application.modules.engine.views.assets')
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
        <?php
        $brandTitle = Yii::t('YupeModule.engine', 'Перейти на главную панели управления');
        $this->widget('application.modules.engine.widgets.YAdminPanel'); ?>
        <div class="container-fluid" id="page"><?php echo $content; ?></div>
        <div id="footer-guard"><!-- --></div>
    </div>

    <footer>
        Copyright &copy; 2009-<?php echo date('Y'); ?>
        <?php echo $this->yupe->poweredBy();?>
        <small class="label label-info"><?php echo $this->yupe->getVersion(); ?></small>
        <br/>
        <a href="http://amylabs.ru/?from=yupe-panel">
            <?php echo Yii::t('YupeModule.engine', 'Разработка и поддержка'); ?></a> - <a href="http://amylabs.ru/?from=yupe-panel" target="_blank">amyLabs
        </a>
        <br/>
        <?php echo Yii::powered(); ?>
        <?php $this->widget('YPerformanceStatistic'); ?>
    </footer>
</body>
</html>