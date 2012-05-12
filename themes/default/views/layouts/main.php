<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=Yii::app()->language?>" lang="<?=Yii::app()->language?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="<?=Yii::app()->language?>" />
    <meta name="keywords" content="<?=$this->keywords?>" />
    <meta name="description" content="<?=$this->description?>" />

    <?php  $jNotify = Yii::app()->assetManager->publish(Yii::app()->theme->basePath.'/web/jquery_notification/');?>
    <?php  Yii::app()->clientScript->registerCssFile($jNotify.'/css/jquery_notification.css');?>
    <?php  Yii::app()->clientScript->registerScriptFile($jNotify.'/js/jquery_notification_v.1.js');?>

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css"
          href="<?=Yii::app()->request->baseUrl?>/css/screen.css"
          media="screen, projection" />
    <link rel="stylesheet" type="text/css"
          href="<?=Yii::app()->request->baseUrl?>/css/print.css"
          media="print" />
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css"
          media="screen, projection"/>
    <![endif]-->

    <link rel="stylesheet" type="text/css"
          href="<?=Yii::app()->request->baseUrl?>/css/main.css" />
    <link rel="stylesheet" type="text/css"
          href="<?=Yii::app()->request->baseUrl?>/css/form.css" />
    <link rel="shortcut icon" href="/favicon.ico" />

    <title><?=CHtml::encode($this->pageTitle)?></title>
</head>
<body>
<div class="container" id="page">
    <div id="header">
        <div id="logo">
            <?=CHtml::encode(Yii::app()->getModule('yupe')->siteDescription)?>
            <iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/small.xml?uid=41001846363811&amp;button-text=05&amp;button-size=s&amp;button-color=orange&amp;targets=%d0%9d%d0%b0+%d1%80%d0%b0%d0%b7%d0%b2%d0%b8%d1%82%d0%b8%d0%b5+%d0%ae%d0%bf%d0%b8!&amp;default-sum=50&amp;fio=on&amp;mail=on" width="130" height="31" style="float:right;"></iframe>
        </div>
    </div>
    <!-- header -->
    <?php $this->widget('application.modules.page.widgets.PagesWidget');?>
    <!-- mainmenu -->
    <?php $this->widget('zii.widgets.CBreadcrumbs', array('links' => $this->breadcrumbs)); ?>
    <!-- breadcrumbs -->
    <?php $this->widget('YFlashMessages');?>
    
    <div class="container">
          <div class="span-19">
            <div id="content">
                <?=$content?>
            </div>
            <!-- content -->
        </div>
        <div class="span-5 last">
            <div id="sidebar">
                <?php $this->widget('application.modules.news.widgets.LastNewsWidget',array('cacheTime' => 0));?>
                <?php $this->widget('application.modules.blog.widgets.BlogsWidget',array('cacheTime' => 0));?>
                <?php $this->widget('application.modules.blog.widgets.LastPostsWidget',array('cacheTime' => 0));?>
            </div>
            <!-- sidebar -->
        </div>
    </div>

    <div id="footer">
        Copyright &copy; 2009-<?php echo date('Y'); ?> <a
        href='http://yupe.ru?from=engine'>Юпи!</a>
        v<?php echo Yii::app()->getModule('yupe')->getVersion();?><br/>
        <?php echo Yii::powered(); ?>
        <?php $this->widget('YPerformanceStatistic');?>
    </div>
    <!-- footer -->
</div>
<!-- page -->
<?php $this->widget('YandexMetrika', array('counter' => 1225179));?>
<!-- yandex.metrika -->
</body>
</html>
