<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo Yii::app()->language?>" lang="<?php echo Yii::app()->language; ; ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="<?php echo Yii::app()->language; ?>" />
    <meta name="keywords" content="<?php echo $this->keywords; ?>" />
    <meta name="description" content="<?php echo $this->description; ?>" />

    <?php $module  = Yii::app()->getModule('yupe');?>

    <?php $jNotify = Yii::app()->assetManager->publish(Yii::app()->theme->basePath.'/web/jquery_notification/'); ?>
    <?php Yii::app()->clientScript->registerCssFile($jNotify.'/css/jquery_notification.css'); ?>
    <?php Yii::app()->clientScript->registerScriptFile($jNotify.'/js/jquery_notification_v.1.js'); ?>

    <?php $jqueryslidemenupath = Yii::app()->assetManager->publish($module->basePath . '/web/jqueryslidemenu/'); ?>
    <?php Yii::app()->clientScript->registerCssFile($jqueryslidemenupath . '/jqueryslidemenu.css'); ?>
    <?php Yii::app()->clientScript->registerScriptFile($jqueryslidemenupath . '/jqueryslidemenu.js'); ?>
    <?php $webPath = Yii::app()->assetManager->publish($module->basePath . '/web/'); ?>

    <script type='text/javascript'>
        var arrowimages = {down:['downarrowclass', '<?php echo $webPath; ?>/jqueryslidemenu/down.gif', 23], right:['rightarrowclass', '<?php echo $webPath; ?>/jqueryslidemenu/right.gif']}
    </script>

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css"
          media="screen, projection" />
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"
          media="print" />
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css"
          media="screen, projection"/>
    <![endif]-->

    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    <link rel="shortcut icon" href="/favicon.ico" />

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<div class="container" id="page">
    <div id="header">
        <div id="logo">
            <a href="<?php echo Yii::app()->baseUrl;?>"><?php echo CHtml::image(Yii::app()->baseUrl.'/web/images/yupe-logo.jpg');?></a>
            <?php echo CHtml::encode($module->siteDescription);?>
            <iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/small.xml?uid=41001846363811&amp;button-text=05&amp;button-size=s&amp;button-color=orange&amp;targets=%d0%9d%d0%b0+%d1%80%d0%b0%d0%b7%d0%b2%d0%b8%d1%82%d0%b8%d0%b5+%d0%ae%d0%bf%d0%b8!&amp;default-sum=50&amp;fio=on&amp;mail=on" width="130" height="31" style="float:right;"></iframe>
        </div>
    </div>
    <!-- header -->
    <?php
    $this->widget('application.modules.menu.widgets.MenuWidget', array(
        'name' => 'top-menu',
        'params' => array('hideEmptyItems' => true),
        'layoutParams' => array('htmlOptions' => array(
            'class' => 'jqueryslidemenu',
            'id' => 'myslidemenu',
         )),
    ));
    ?>
    <!-- mainmenu -->
    <?php $this->widget('zii.widgets.CBreadcrumbs', array('links' => $this->breadcrumbs)); ?>
    <!-- breadcrumbs -->
    <?php $this->widget('YFlashMessages');?>
    
    <div class="container">
          <div class="span-19">
            <div id="content">
                <?php echo $content; ?>
            </div>
            <!-- content -->
        </div>
        <div class="span-5 last">
            <div id="sidebar">
                <div class="portlet">
                    <div class="portlet-decoration">
                        <div class="portlet-title">Юпи! на GitHub!</div>
                    </div>
                    <div class="portlet-content">
                        <a href="https://github.com/yupe/yupe" title="Юпи! на GitHub!" target="_blank"><?php echo CHtml::image(Yii::app()->baseUrl.'/web/images/banners/125yupe.jpg','Юпи! на GitHub!',array('alt' => 'Юпи! на GitHub!'));?></a>
                    </div>
                </div>
                <?php $this->widget('application.modules.blog.widgets.LastPostsWidget',array('cacheTime' => 0));?>
                <?php $this->widget('application.modules.blog.widgets.TagCloudWidget',array('cacheTime' => 0));?>
                <?php $this->widget('application.modules.feedback.widgets.FaqWidget',array('cacheTime' => 0));?>
                <?php $this->widget('application.modules.news.widgets.LastNewsWidget',array('cacheTime' => 0));?>
                <?php $this->widget('application.modules.blog.widgets.BlogsWidget',array('cacheTime' => 0));?>
                <?php $this->widget('application.modules.user.widgets.LastLoginUsersWidget',array('cacheTime' => 0));?>
            </div>
            <!-- sidebar -->
        </div>
    </div>

    <div id="footer">
        Copyright &copy; 2009-<?php echo date('Y'); ?> <a
        href='http://yupe.ru?from=engine'>Юпи!</a>
        v<?php echo $module->getVersion();?><br/>
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
