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
    <link rel="icon" type="image/png" href="<?php echo Yii::app()->baseUrl;?>/web/images/favicon.png" />
    <title><?php echo CHtml::encode(Yii::app()->name); ?> <?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php
    $mainAssets = Yii::app()->assetManager->publish(
        Yii::getPathOfAlias('application.modules.yupe.views.assets')
    );
    Yii::app()->clientScript->registerCssFile($mainAssets . '/css/styles.css');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/main.js');
    if (($langs = $this->yupe->languageSelectorArray) != array())
        Yii::app()->clientScript->registerCssFile($mainAssets. '/css/flags.css');
    ?>
</head>

<body>
    <div id="overall-wrap">
        <!-- mainmenu -->
        <?php
        $brandTitle = Yii::t('YupeModule.yupe', 'Перейти на главную панели управления');

        $this->widget('YAdminPanel'); ?>
        <div class="container-fluid" id="page"><?php echo $content; ?></div>
        <div id="footer-guard"><!-- --></div>
    </div>
    <footer>
        Copyright &copy; 2009-<?php echo date('Y'); ?>
        <a href='<?php echo $this->yupe->brandUrl; ?>'>
            <?php echo CHtml::encode(Yii::app()->name); ?>
        </a> 
        <small class="label label-info"><?php echo $this->yupe->getVersion(); ?></small>
        <br/>
        <a href="http://yupe.ru/feedback/index?from=engine">
            <?php echo Yii::t('YupeModule.yupe', 'Разработка и поддержка'); ?></a> - <a href="mailto:team@yupe.ru">yupe team
        </a>
        <br/>
        <?php echo Yii::powered(); ?>
        <?php $this->widget('YPerformanceStatistic'); ?>
    </footer>
</body>
</html>