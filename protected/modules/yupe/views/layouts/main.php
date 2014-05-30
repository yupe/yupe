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
        <?php
        $brandTitle = Yii::t('YupeModule.yupe', 'Go to main page of control panel');
        $this->widget('yupe\widgets\YAdminPanel'); ?>
        <div class="container-fluid" id="page"><?php echo $content; ?></div>
        <div id="footer-guard"><!-- --></div>
    </div>

    <footer>
        Copyright &copy; 2010-<?php echo date('Y'); ?>
        <?php echo $this->yupe->poweredBy();?>
        <small class="label label-info"><?php echo $this->yupe->getVersion(); ?></small>
        <br/>
        <a href="http://amylabs.ru/?from=yupe-panel">
            <?php echo Yii::t('YupeModule.yupe', 'Development and support'); ?></a> - <a href="http://amylabs.ru/?from=yupe-panel" target="_blank">amyLabs
        </a>
        <br/>
        <?php echo Yii::powered(); ?>
        <?php $this->widget('yupe\widgets\YPerformanceStatistic'); ?>
    </footer>
</body>
</html>