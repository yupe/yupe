<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
<head prefix="og: http://ogp.me/ns#
    fb: http://ogp.me/ns/fb#
    article: http://ogp.me/ns/article#">
    <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1">
    <meta charset="<?php echo Yii::app()->charset; ?>"/>
    <meta name="keywords" content="<?php echo $this->keywords; ?>"/>
    <meta name="description" content="<?php echo $this->description; ?>"/>
    <meta property="og:title" content="<?php echo CHtml::encode($this->pageTitle); ?>"/>
    <meta property="og:description" content="<?php echo $this->description; ?>"/>
    <?php
        $mainAssets = Yii::app()->AssetManager->publish(
            Yii::app()->theme->basePath . "/web/"
        );

        Yii::app()->clientScript->registerCssFile($mainAssets . '/css/yupe.css');        
        Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/blog.js');
    ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>
<?php $this->widget('application.modules.menu.widgets.MenuWidget', array('name' => 'top-menu')); ?>
<!-- container -->
<div class='container'>
    <!-- flashMessages -->
    <?php $this->widget('yupe\widgets\YFlashMessages'); ?>
    <!-- breadcrumbs -->
    <?php $this->widget(
        'bootstrap.widgets.TbBreadcrumbs',
        array(
            'links' => $this->breadcrumbs,
        )
    );?>
    <div class="row">
        <!-- content -->
        <section class="span9 content">
            <?php echo $content; ?>
        </section>
        <!-- content end-->

        <!-- sidebar -->
        <aside class="span3 sidebar">

            <div class="widget blogs-widget">
                <?php $this->widget('yupe\widgets\RandomDataWidget', array(
                    'data' => array(
                        CHtml::link(CHtml::image(Yii::app()->baseUrl.'/web/images/amyLabs.jpg','amylabs - разработка на Юпи! и Yii !'),'http://amylabs.ru?from=yupe-rb', array('title' => 'amylabs - разработка на Юпи! и Yii !','target' => '_blank')),
                        CHtml::link(CHtml::image(Yii::app()->baseUrl.'/web/images/yupe-logo.jpg','Юпи! - cms на Yii !'),'http://yupe.ru?from=yupe-rb', array('title' => 'Юпи! - cms на Yii !','target' => '_blank')),
                     )
                )); ?>
            </div>

            <?php if (Yii::app()->user->isAuthenticated()): ?>
                <div class="widget last-login-users-widget">
                    <?php $this->widget('application.modules.user.widgets.ProfileWidget'); ?>
                </div>
            <?php endif; ?>         

             <div class="widget stream-widget">
                <?php $this->widget('application.modules.blog.widgets.StreamWidget', array('cacheTime' => 300)); ?>
            </div>

            <div class="widget last-posts-widget">
                <?php $this->widget('application.modules.blog.widgets.LastPostsWidget', array('cacheTime' => $this->yupe->coreCacheTime)); ?>
            </div>

            <div class="widget blogs-widget">
                <?php $this->widget('application.modules.blog.widgets.BlogsWidget', array('cacheTime' => $this->yupe->coreCacheTime)); ?>
            </div>

            <div class="widget tags-cloud-widget">
                <?php $this->widget(
                    'application.modules.yupe.extensions.taggable.widgets.TagCloudWidget.TagCloudWidget',
                    array('cacheTime' => $this->yupe->coreCacheTime, 'model' => 'Post', 'count' => 50)
                ); ?>
            </div>

            <div class="widget last-questions-widget">
                <?php $this->widget('application.modules.feedback.widgets.FaqWidget', array('cacheTime' => $this->yupe->coreCacheTime)); ?>
            </div>            

        </aside>
        <!-- sidebar end -->
    </div>
    <!-- footer -->
    <?php $this->renderPartial('//layouts/_footer'); ?>
    <!-- footer end -->
</div>
<!-- container end -->
<?php $this->widget(
    "application.modules.contentblock.widgets.ContentBlockWidget",
    array("code" => "STAT", "silent" => true)
); ?>
</body>
</html>
