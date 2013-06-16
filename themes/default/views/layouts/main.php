<?php
/**
 * Шаблон для layout/main:
 *
 * @category YupeLayout
 * @package  YupeCMS
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
?>
<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
<head>
    <meta charset="UTF-8"/>
    <meta name="keywords" content="<?php echo $this->keywords; ?>"/>
    <meta name="description" content="<?php echo $this->description; ?>"/>
    <link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl; ?>/favicon.ico"/>

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/web/css/screen.css"
          media="screen, projection"/>
    <!--[if lt IE 8]>
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/web/css/ie.css"
          media="screen, projection"/>
    <![endif]-->

    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/web/css/main.css"/>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<?php $this->widget('application.modules.yupe.widgets.YAdminPanel'); ?>
<div class="container" id="page">
    <div id="header">
        <div id="logo">
            <a href="<?php echo CHtml::normalizeUrl(array("/site/index")) ?>">
                <?php echo CHtml::image(Yii::app()->baseUrl . '/web/images/main-logo.png'); ?>
            </a>
            <span style="vertical-align: 10px; margin-left: 20px; font-size: 27px;">
                <?php echo CHtml::encode($this->description); ?>
            </span>

            <div id="header-right">
                <?php $this->widget('application.modules.yupe.widgets.YLanguageSelector'); ?>
                <div class='yupeDownload'>
                    <?php
                    echo CHtml::link(
                        'СКАЧАТЬ ЮПИ! <br/>' . $this->yupe->getVersion(),
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
    <?php $this->widget('YFlashMessages'); ?>

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
                <br/>

                <div class="portlet">
                    <?php
                    echo CHtml::link(
                        CHtml::image(
                            Yii::app()->baseUrl . '/web/images/github.jpg',
                            'Юпи! - классная CMS на Yiiframework!'
                        ), 'http://github.com/yupe/yupe', array(
                            'target' => '_blank'
                        )
                    ); ?>
                </div>
                <?php $this->widget('application.modules.blog.widgets.LastPostsWidget', array('cacheTime' => 0)); ?>

                <div class="portlet">
                <a class="twitter-timeline"  href="https://twitter.com/YupeCms"  data-widget-id="342373817932451841">Твиты пользователя @YupeCms</a>
                   <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                </div>

                <?php $this->widget('application.modules.yupe.extensions.taggable.widgets.TagCloudWidget.TagCloudWidget', array('cacheTime' => 0, 'model' => 'Post')); ?>
                <?php $this->widget('application.modules.feedback.widgets.FaqWidget', array('cacheTime' => 0)); ?>
                <?php //$this->widget('application.modules.news.widgets.LastNewsWidget', array('cacheTime' => 0)); ?>
                <?php $this->widget('application.modules.blog.widgets.BlogsWidget', array('cacheTime' => 0)); ?>
                <?php $this->widget('application.modules.user.widgets.LastLoginUsersWidget', array('cacheTime' => 0)); ?>
            </div>
            <!-- sidebar -->
        </div>
    </div>

    <div id="footer">
        Copyright &copy; 2009-<?php echo date('Y'); ?> <a href="<?php echo Yii::app()->createUrl('/blog/rss/feed/');?>"><img src="<?php echo Yii::app()->theme->baseUrl?>/web/images/rss.png" alt="Подпишитесь на обновления" title="Подпишитесь на обновления"></a>
        <br/><?php echo $this->yupe->poweredBy(); ?>
        <?php echo $this->yupe->getVersion(); ?><br/> <?php echo Yii::powered(); ?>

        <?php $this->widget('YPerformanceStatistic'); ?>
    </div>
    <!-- footer -->
</div>
<!-- page -->
<?php $this->widget("application.modules.contentblock.widgets.ContentBlockWidget", array("code" => "STAT", "silent" => true)); ?>
</body>
</html>