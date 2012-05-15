<?php $module = Yii::app()->getModule('yupe');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo CHtml::encode(Yii::app()->name);?> <?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel="stylesheet" type="text/css"  href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css"/>
</head>

<body>
<div id="overall-wrap">
<!-- mainmenu -->
    <?php

        $items=$module->getModules(true);

        // Для верхнего меню делаем иконки белыми ибо он с черным фоном
        foreach($items as &$itm)
            if (isset($itm['icon']) && $itm['icon'])
                $itm['icon'].=" white";

        $this->widget('bootstrap.widgets.BootNavbar', array(
            'fixed'=> 'top',
            'fluid'=>true,
            'brand'=>Yii::t('yupe',"Юпи!"),
            'brandUrl' => CHtml::normalizeUrl(array("/yupe/backend")),
            'collapse'=>false, // requires bootstrap-responsive.css
            'items'=>array(
                array(
                    'class'=>'bootstrap.widgets.BootMenu',
                    'items'=>$items,
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
