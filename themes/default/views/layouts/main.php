<?php
    $static = Yii::app()->assetManager->publish(
        Yii::app()->theme->basePath . '/web'
    );
?>
<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
    <head prefix="og: http://ogp.me/ns#
    fb: http://ogp.me/ns/fb#
    article: http://ogp.me/ns/article#">
    <meta http-equiv = "X-UA-Compatible" content="IE=edge;chrome=1">
    <meta charset="<?php echo Yii::app()->charset; ?>"/>
    <meta name="keywords" content="<?php echo $this->keywords; ?>"/>
    <meta name="description" content="<?php echo $this->description; ?>"/>
    <meta property="og:title" content="<?php echo CHtml::encode($this->pageTitle); ?>"/>
    <meta property="og:description" content="<?php echo $this->description; ?>"/>
    <link rel="shortcut icon" href="<?php echo $static; ?>/images/favicon.ico"/>
    <link rel="stylesheet" href="<?php echo $static; ?>/css/main.css"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php
        if(Yii::app()->hasComponent('highlightjs'))
            Yii::app()->highlightjs->loadClientScripts();
        ?>
    <!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    </head>
    <script>
    var baseUrl = '<?php echo Yii::app()->baseUrl?>';
    </script>

<body>
    <?php $this->widget('application.modules.menu.widgets.MenuWidget',array('name' => 'top-menu'));?>
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
        <!-- content start-->
        <section class="span9 content">
        <?php echo $content; ?>
        </section>
        <!-- content end-->
        <!-- sidebar start -->
        <aside class="span3 sidebar">

            <div class="widget ya-money">
                <iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/small.xml?uid=41001846363811&amp;button-text=05&amp;button-size=l&amp;button-color=orange&amp;targets=%D0%9D%D0%B0+%D1%80%D0%B0%D0%B7%D0%B2%D0%B8%D1%82%D0%B8%D0%B5+%D0%AE%D0%BF%D0%B8!&amp;default-sum=100&amp;fio=on&amp;mail=on" width="auto" height="54"></iframe>
            </div>

            <div class="widget twitter-widget">
                <a class="twitter-timeline" href="https://twitter.com/YupeCms" data-widget-id="342373817932451841">
                Твиты пользователя @YupeCms
                </a>
            </div>

                <?php if(Yii::app()->user->isAuthenticated()):?>
                                <div class="widget last-login-users-widget">
                                    <?php $this->widget('application.modules.user.widgets.ProfileWidget');?>
            </div>
                <?php endif;?>

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
        </aside>
    </div>
            <!-- sidebar end -->
            <?php $this->renderPartial('//layouts/_footer');?>
        
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
