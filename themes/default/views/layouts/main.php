<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
<head>
    <meta charset="<?php echo Yii::app()->charset; ?>"/>
    <meta name="keywords" content="<?php echo $this->keywords; ?>"/>
    <meta name="description" content="<?php echo $this->description; ?>"/>
    <link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/web/images/favicon.ico"/>
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/web/css/main.css"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php
    if(Yii::app()->hasComponent('highlightjs'))
        Yii::app()->highlightjs->loadClientScripts();
    ?>
</head>

<script type="text/javascript">
    var baseUrl = '<?php echo Yii::app()->baseUrl?>';
</script>

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
        <div class="row-fluid">
            <div class="span9">
                <!-- content start-->
                <div class="content">
                    <?php echo $content; ?>
                </div>
                <!-- content end-->
            </div>

            <!-- sidebar start -->
            <div class="span3 sidebar">

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
            </div>
            <!-- sidebar end -->

            <div class="row-fluid">
                <div class="span12">
                    <div class="span3">
                        <ul class="unstyled">
                            <li>Ресурсы</li>
                            <li>
                                <!--                        <i class="icon-twitter">-->
                                <a href="https://twitter.com/yupecms" target="_blank"></i> Twitter</a>
                            </li>
                            <li>
                                <!--                        <i class="icon-vk"></i>-->
                                <a href="http://vk.com/amylabs" target="_blank"> Вконтакте</a>
                            </li>
                            <li>
                                <!--                        <i class="icon-facebook"></i>-->
                                <a href="https://www.facebook.com/amylabs.ru" target="_blank"> Facebook</a>
                            </li>
                            <li>
                                <!--                        <i class="icon-google-plus"></i>-->
                                <a href="https://plus.google.com/u/0/b/111468098477631231532/111468098477631231532/posts"
                                   target="_blank">Google+</a>
                            </li>
                            <li><a href="http://yupe.ru/blog/yupe-mini-cms-yii" target="_blank">Блог</a></li>
                            <li><a href="http://yupe.ru/" target="_blank">Сайт</a></li>
                        </ul>
                    </div>
                    <div class="span3">
                        <ul class="unstyled">
                            <li>Поддержка</li>
                            <li><a href="http://yupe.ru/docs/index.html" target="_blank">Документация</a></li>
                            <li><a href="http://api.yupe.ru/" target="_blank">API</a></li>
                            <li><a href="http://yupe.ru/talk/" target="_blank">Форум</a></li>
                            <li><a href="http://yupe.ru/wiki/default/pageIndex" target="_blank">Wiki</a></li>
                            <li><a href="http://yupe.ru/feedback/faq/" target="_blank">FAQ</a></li>
                            <li><a href="http://yupe.ru/feedback/index/" target="_blank">Контакты</a></li>
                        </ul>
                    </div>
                    <div class="span3">
                        <ul class="unstyled">
                            <li>Юпи!</li>
                            <li><a href="http://yupe.ru/pages/about/" target="_blank">О проекте</a></li>
                            <li><a href="http://yupe.ru/docs/yupe/team.html" target="_blank">Команда</a></li>
                            <li><a href="https://github.com/yupe/yupe/" target="_blank">Github</a></li>
                            <li><a href="https://github.com/yupe/yupe-ext/" target="_blank">Доп. модули</a></li>
                            <li><a href="http://yupe.ru/docs/yupe/capability.html" target="_blank">Возможности</a></li>
                            <li><a href="http://yupe.ru/docs/yupe/assistance.project.html" target="_blank">Помощь проекту</a>
                            </li>
                        </ul>
                    </div>
                    <div class="span3">
                        <ul class="unstyled">
                            <li>Друзья</li>
                            <li><a href="http://allframeworks.ru" target="_blank">allframeworks</a></li>
                            <li><a href="http://amylabs.ru" target="_blank">amylabs</a></li>
                            <li><a href="http://yupe.ru/feedback/index/" target="_blank">Хочешь в друзья?</a></li>
                            <li><a href="http://amylabs.ru/contact?from=yupe" target="_blank">Коммерческая поддержка</a></li>
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