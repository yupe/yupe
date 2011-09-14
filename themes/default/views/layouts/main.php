<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="<?php echo Yii::app()->language;?>"/>
    <meta name="keywords" content="<?php echo $this->keywords;?>"/>
    <meta name="description" content="<?php echo $this->description;?>"/>

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css"
          media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"
          media="print"/>
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css"
          media="screen, projection"/>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"/>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body>

<div class="container" id="page">

    <div id="header">
        <div id="logo"><?php echo CHtml::encode(Yii::app()->getModule('yupe')->siteDescription); ?></div>
    </div>
    <!-- header -->
    <div id="mainmenu">
        <?php $this->widget('application.modules.page.widgets.PagesWidget');?>
    </div>
    <!-- mainmenu -->

    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                                                         'links' => $this->breadcrumbs,
                                                    )); ?><!-- breadcrumbs -->

    <div class="container">
        <div class="span-19">

            <?php $this->widget('FlashMessagesWidget');?>

            <div id="content">
                <?php echo $content; ?>
            </div>
            <!-- content -->
        </div>
        <div class="span-5 last">
            <div id="sidebar">
                <?php $this->widget('application.modules.news.widgets.NewsWidget');?>
            </div>
            <!-- sidebar -->
        </div>
    </div>


    <div id="footer">
        Copyright &copy; 2009-<?php echo date('Y'); ?> <a href='http://yupe.ru?from=engine'>Юпи!</a>
        v<?php echo Yii::app()->yupe->getVersion();?><br/>
        <?php echo Yii::powered(); ?>
        <?php $this->widget('PerformanceStatisticWidget');?>
    </div>
    <!-- footer -->

</div>
<!-- page -->

<?php $this->widget('YandexMetrikaWidget', array('counter' => 1225179));?>

</body>

</html>
