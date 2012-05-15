<?php $module = Yii::app()->getModule('yupe');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" type="text/css"  href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css"/>
    <title><?php echo CHtml::encode(Yii::app()->name);?> <?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div id="overall-wrap">
<!-- mainmenu -->
    <?php
        $this->widget('bootstrap.widgets.BootNavbar', array(
            'fixed'=> 'top',
            'fluid'=>true,
            'brand'=>Yii::t('yupe',"Юпи!"),
            'brandUrl'=>"/yupe/backend",
            'collapse'=>false, // requires bootstrap-responsive.css
            'items'=>array(
                array(
                    'class'=>'bootstrap.widgets.BootMenu',
                    'items'=>$module->getModules(true),
                ),
            ),
        ));
    ?>
    <div class="container-fluid" id="page">
        <?php echo $content; ?>
    </div>
    <div id="footer-guard"><!-- --></div>

</div>

    <footer>
        Copyright &copy; 2009-<?php echo date('Y'); ?> <a
        href='<?php echo $module->brandUrl?>'><?php echo CHtml::encode(Yii::app()->name);?></a> <a href="mailto:team@yupe.ru">yupe team</a><br/>
        <?php echo Yii::powered(); ?>
        <?php $this->widget('YPerformanceStatistic');?>
    </footer>

</body>
</html>
