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
    <?php  $this->widget('application.modules.menu.widgets.MenuWidget',array('name' => 'top-menu'));?>

    <div class='container'>
        <?php $this->widget('YFlashMessages'); ?>
        <!-- flashMessages -->
        <?php $this->widget(
            'bootstrap.widgets.TbBreadcrumbs',
            array(
                'links' => $this->breadcrumbs,
            )
        ); ?>
        <div class="row">
            <div class="span9">
                <!-- content start-->
                <div class="content">
                    <?php echo $content; ?>
                </div>
                <!-- content end-->
            </div>

            <!-- sidebar start -->
            <div class="span3 sidebar">
                <div class="widget twitter-widget">
                    <a class="twitter-timeline" href="https://twitter.com/YupeCms" data-widget-id="342373817932451841">
                        Твиты пользователя @YupeCms
                    </a>
                </div>

                <div class="widget blogs-widget">
                    <?php $this->widget('application.modules.blog.widgets.BlogsWidget', array('cacheTime' => 0)); ?>
                </div>

                <div class="widget last-posts-widget">
                    <?php $this->widget('application.modules.blog.widgets.LastPostsWidget', array('cacheTime' => 0)); ?>
                </div>

                <div class="widget tags-cloud-widget">
                    <?php $this->widget(
                        'application.modules.yupe.extensions.taggable.widgets.TagCloudWidget.TagCloudWidget',
                        array('cacheTime' => 0, 'model' => 'Post')
                    ); ?>
                </div>

                <div class="widget last-questions-widget">
                    <?php $this->widget('application.modules.feedback.widgets.FaqWidget', array('cacheTime' => 0)); ?>
                </div>

                <div class="widget last-login-users-widget">
                    <?php $this->widget(
                        'application.modules.user.widgets.LastLoginUsersWidget',
                        array('cacheTime' => 0)
                    ); ?>
                </div>
            </div>
            <!-- sidebar end -->

            <div class="row-fluid">
                <div class="span12">
                    <div class="span2" style="width: 15%;">
                        <ul class="unstyled">
                            <li>GitHub
                            <li>
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Contact & support</a></li>
                            <li><a href="#">Enterprise</a></li>
                            <li><a href="#">Site status</a></li>
                        </ul>
                    </div>
                    <div class="span2" style="width: 15%;">
                        <ul class="unstyled">
                            <li>Applications
                            <li>
                            <li><a href="#">Product for Mac</a></li>
                            <li><a href="#">Product for Windows</a></li>
                            <li><a href="#">Product for Eclipse</a></li>
                            <li><a href="#">Product mobile apps</a></li>
                        </ul>
                    </div>
                    <div class="span2" style="width: 15%;">
                        <ul class="unstyled">
                            <li>Services
                            <li>
                            <li><a href="#">Web analytics</a></li>
                            <li><a href="#">Presentations</a></li>
                            <li><a href="#">Code snippets</a></li>
                            <li><a href="#">Job board</a></li>
                        </ul>
                    </div>
                    <div class="span2" style="width: 15%;">
                        <ul class="unstyled">
                            <li>Documentation<li>
                            <li><a href="#">Product Help</a></li>
                            <li><a href="#">Developer API</a></li>
                            <li><a href="#">Product Markdown</a></li>
                            <li><a href="#">Product Pages</a></li>
                        </ul>
                    </div>
                    <div class="span2" style="width: 15%;">
                        <ul class="unstyled">
                            <li>More
                            <li>
                            <li><a href="#">Training</a></li>
                            <li><a href="#">Students & teachers</a></li>
                            <li><a href="#">The Shop</a></li>
                            <li><a href="#">Plans & pricing</a></li>
                            <li><a href="#">Contact us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="span8">
                        <?php echo CHtml::link(
                            'Разработка и поддержка интернет-проектов',
                            'http://amylabs.ru?from=yupe'
                        ); ?>
                    </div>
                    <div class="span4">
                        <p class="muted pull-right">© 2009 - <?php echo date('Y'); ?> <?php echo CHtml::link(
                                'amyLabs',
                                'http://amylabs.ru?from=yupe'
                            ); ?> && Юпи! team <?php echo Yii::app()->getModule('yupe')->poweredBy(); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- page -->
<?php $this->widget(
    "application.modules.contentblock.widgets.ContentBlockWidget",
    array("code" => "STAT", "silent" => true)
); ?>
    <script type="text/javascript">
        !function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
            if (!d.getElementById(id)) {
                js = d.createElement(s);
                js.id = id;
                js.src = p + "://platform.twitter.com/widgets.js";
                fjs.parentNode.insertBefore(js, fjs);
            }
        }(document, "script", "twitter-wjs");
    </script>
</body>
</html>