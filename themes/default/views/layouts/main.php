<?php
/**
 * Шаблон для layout/main:
 * 
 *   @category YupeLayout
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo Yii::app()->language; ?>" lang="<?php echo Yii::app()->language; ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="<?php echo Yii::app()->language; ?>"/>
    <meta name="keywords" content="<?php echo $this->keywords; ?>"/>
    <meta name="description" content="<?php echo $this->description; ?>"/>

    <link rel="icon" type="image/png" href="<?php echo Yii::app()->baseUrl;?>/web/images/favicon.png" />

    <?php $module = Yii::app()->getModule('yupe'); ?>

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->theme->baseUrl; ?>/web/css/screen.css"
          media="screen, projection"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->theme->baseUrl; ?>/web/css/print.css"
          media="print"/>
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->theme->baseUrl; ?>/web/css/ie.css"
          media="screen, projection"/>
    <![endif]-->

    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->theme->baseUrl; ?>/web/css/main.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->theme->baseUrl; ?>/web/css/form.css"/>
    <link rel="shortcut icon" href="/favicon.ico"/>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<?php $this->widget('application.modules.yupe.widgets.YAdminPanel'); ?>
<div class="container" id="page">
    <div id="header">
        <div id="logo">
            <a href="<?php echo CHtml::normalizeUrl(array("/site/index"))?>"><?php echo CHtml::image(Yii::app()->baseUrl . '/web/images/main-logo.png');?></a>
            <span style="vertical-align: 40px; margin-left: 20px; font-size: 25px;">
                <?php echo CHtml::encode($module->siteDescription);?>
            </span>
            <div id="header-right">
                <?php $this->widget('application.modules.yupe.widgets.YLanguageSelector'); ?>
                <div class='yupeDownload'>
                    <?php
                    echo CHtml::link(
                        'СКАЧАТЬ ЮПИ! <br/><b> '
                        . Yii::app()->getModule('yupe')->getVersion()
                        . '</b>',
                        'https://github.com/yupe/yupe/archive/master.zip'
                    ); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- header -->
    <?php
    $this->widget(
        'application.modules.menu.widgets.MenuWidget', array(
            'name' => 'top-menu',
            'params' => array(
                'hideEmptyItems' => true
            ),
            'layoutParams' => array(
                'htmlOptions' => array(
                    'class' => 'jqueryslidemenu',
                    'id' => 'myslidemenu',
                )
            ),
        )
    ); ?>
    <?php $this->widget('application.modules.yupe.extensions.jquerySlideMenu.JquerySlideMenuWidget'); ?>
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
                    <?php
                    echo CHtml::link(
                        CHtml::image(
                            Yii::app()->baseUrl . '/web/images/cooll.png',
                            'Юпи! - классная CMS на Yiiframework!'
                        ), 'http://yupe.ru?from=o-b', array(
                            'target' => '_blank'
                        )
                    ); ?>
                </div>
                <br />
                <?php $this->widget('application.modules.blog.widgets.LastPostsWidget', array('cacheTime' => 0)); ?>
                <?php $this->widget('application.modules.yupe.extensions.taggable.widgets.TagCloudWidget.TagCloudWidget', array('cacheTime' => 0, 'model' => 'Post')); ?>
                <?php $this->widget('application.modules.feedback.widgets.FaqWidget', array('cacheTime' => 0)); ?>
                <?php //$this->widget('application.modules.news.widgets.LastNewsWidget', array('cacheTime' => 0)); ?>
                <?php $this->widget('application.modules.blog.widgets.BlogsWidget', array('cacheTime' => 0));?>
                <?php $this->widget('application.modules.user.widgets.LastLoginUsersWidget', array('cacheTime' => 0)); ?>
            </div>
            <!-- sidebar -->
        </div>
    </div>

    <div id="footer">
        Copyright &copy; 2009-<?php echo date('Y'); ?>
        <?php echo Yii::app()->getModule('yupe')->poweredBy();?>
        v<?php echo $module->getVersion();?><br/> <?php echo Yii::powered(); ?>

        <?php $this->widget('YPerformanceStatistic');?>
    </div>
    <!-- footer -->
</div>
<!-- page -->
<?php $this->widget("application.modules.contentblock.widgets.ContentBlockWidget", array("code" => "STAT","silent" => true)); ?>
</body>
</html>
