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
    <link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/web/images/favicon.ico"/>
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/web/css/main.css"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<?php $this->widget('application.modules.yupe.widgets.YAdminPanel'); ?>
<div class='container'>
    <?php  $this->widget('application.modules.menu.widgets.MenuWidget',array('name' => 'top-menu'));?>

    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array('links'    => $this->breadcrumbs));?>
    <!-- breadcrumbs -->

    <?php $this->widget('YFlashMessages'); ?>
    <!-- flashMessages -->

    <div class="row-fluid">
        <div class="span9">
            <div class="container-fluid" id="page">
                <?php
                $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                        'links'=>$this->breadcrumbs,
                    ));
                ?>
                <?php echo $content; ?>
            </div>
            <!-- content -->
        </div>
        <div class="span3">
            <div id="sidebar">
                <div class="portlet">
                    <a class="twitter-timeline" href="https://twitter.com/YupeCms" data-widget-id="342373817932451841">Твиты
                        пользователя @YupeCms</a>
                    <script>!function (d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                            if (!d.getElementById(id)) {
                                js = d.createElement(s);
                                js.id = id;
                                js.src = p + "://platform.twitter.com/widgets.js";
                                fjs.parentNode.insertBefore(js, fjs);
                            }
                        }(document, "script", "twitter-wjs");</script>
                </div>

                <?php $this->widget('application.modules.blog.widgets.BlogsWidget', array('cacheTime' => 0)); ?>
                <?php $this->widget('application.modules.blog.widgets.LastPostsWidget', array('cacheTime' => 0)); ?>
                <?php $this->widget('application.modules.yupe.extensions.taggable.widgets.TagCloudWidget.TagCloudWidget', array('cacheTime' => 0, 'model' => 'Post')); ?>
                <?php $this->widget('application.modules.feedback.widgets.FaqWidget', array('cacheTime' => 0)); ?>
                <?php $this->widget('application.modules.user.widgets.LastLoginUsersWidget', array('cacheTime' => 0));?>
            </div>
            <!-- sidebar -->
        </div>

    </div>

    <footer>
        <p>
            &copy; <?php echo CHtml::link('amyLabs','http://amylabs.ru/')?> && Юпи! team 2009 - <?php echo date('Y');?>
            <?php echo $this->yupe->poweredBy(); ?>
        </p>
    </footer>
<!-- page -->
<?php $this->widget(
    "application.modules.contentblock.widgets.ContentBlockWidget",
    array("code" => "STAT", "silent" => true)
); ?>
</body>
</html>