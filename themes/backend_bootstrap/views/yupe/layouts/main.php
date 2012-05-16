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

    $rightMenu = array(
        array(
            'icon' => 'home white',
            'label' => Yii::t('yupe', 'На сайт'),
            'url' => array('/')
        ),
        array(
        'icon' => 'off white',
        'label' => Yii::t('yupe', 'Выйти'),
        'url' => array('/user/account/logout'),
        'visible' => Yii::app()->user->isAuthenticated()
        ),
    );

    $this->widget('bootstrap.widgets.BootNavbar', array(
            'fixed'=> 'top',
            'fluid'=>true,
            'brand'=>"<img src='".Yii::app()->theme->baseUrl."/images/logo.png' width=\"38\" height=\"38\" title=\"".Yii::t('yupe','Перейти на главную панели управления')."\"/>",//Yii::t('yupe',"Юпи!"),
            'brandUrl' => CHtml::normalizeUrl(array("/yupe/backend")),
            'collapse'=>false, // requires bootstrap-responsive.css
            'items'=>array(
                array(
                    'class'=>'bootstrap.widgets.BootMenu',
                    'items'=>$items,
                ),
                array(
                    'class'=>'bootstrap.widgets.BootMenu',
                    'htmlOptions'=>array('class'=>'pull-right'),
                    'items'=>$rightMenu,
                ),
                "<div style='float:right;line-height:15px;'><small style='font-size: 80%;'>".Yii::t('yupe','Администатор')."</small><br /><span class='label'>".Yii::app()->user->nick_name."</span></div>",
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
