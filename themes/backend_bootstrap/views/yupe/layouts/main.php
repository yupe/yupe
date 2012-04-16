<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
        $bootstrapPath = Yii::app()->assetManager->publish(Yii::app()->getModule('yupe')->basePath . '/web/bootstrap/');
        Yii::app()->clientScript->registerCssFile($bootstrapPath . '/css/bootstrap.min.css');
        Yii::app()->clientScript->registerScriptFile($bootstrapPath . '/js/bootstrap.min.js');
        Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/css/styles.css');
/*    <link rel="stylesheet" type="text/css"  href="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css"  href="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/css/bootstrap-responsive.min.css"/>
*/
?>
    <link rel="stylesheet" type="text/css"  href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css"/>
    <title><?php echo CHtml::encode(Yii::app()->name);?> <?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div id="overall-wrap">
<!-- mainmenu -->
    <?php $this->widget('YBSNavbar', array(
                                                  'hideEmptyItems' => true,
                                                  'items' => Yii::app()->getModule('yupe')->getModules(true),
                                                  'fixed'=> 'top',
                                                  'brand' => "Yupe!"
                                             )); ?>

    <div class="container-fluid" id="page">
        <?php echo $content; ?>
    </div>
    <div id="footer-guard"><!-- --></div>

</div>

    <footer>
        Copyright &copy; 2009-<?php echo date('Y'); ?> <a
        href='<?php echo Yii::app()->getModule('yupe')->brandUrl?>'><?php echo CHtml::encode(Yii::app()->name);?></a><br/>
        <?php echo Yii::powered(); ?>
        <?php $this->widget('YPerformanceStatistic');?>
    </footer>

</body>
</html>
