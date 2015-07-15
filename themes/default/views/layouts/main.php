<!DOCTYPE html>
<html lang="<?= Yii::app()->language; ?>">
<head>
    <?php \yupe\components\TemplateEvent::fire(DefautThemeEvents::HEAD_START);?>
    <?php Yii::app()->getController()->widget(
        'vendor.chemezov.yii-seo.widgets.SeoHead',
        array(
            'httpEquivs' => array(
                'Content-Type' => 'text/html; charset=utf-8',
                'X-UA-Compatible' => 'IE=edge,chrome=1',
                'Content-Language' => 'ru-RU'
            ),
            'defaultTitle' => $this->yupe->siteName,
            'defaultDescription' => $this->yupe->siteDescription,
            'defaultKeywords' => $this->yupe->siteKeyWords,
        )
    ); ?>

    <?php
    $mainAssets = Yii::app()->getTheme()->getAssetsUrl();

    Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/main.css');
    Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/flags.css');
    Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/yupe.css');
    Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/blog.js');
    Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/bootstrap-notify.js');
    Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/jquery.li-translit.js');
    ?>
    <script type="text/javascript">
        var yupeTokenName = '<?= Yii::app()->getRequest()->csrfTokenName;?>';
        var yupeToken = '<?= Yii::app()->getRequest()->getCsrfToken();?>';
    </script>
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="http://yandex.st/highlightjs/8.2/styles/github.min.css">
    <script src="http://yastatic.net/highlightjs/8.2/highlight.min.js"></script>
    <?php \yupe\components\TemplateEvent::fire(DefautThemeEvents::HEAD_END);?>
</head>

<body>

<?php \yupe\components\TemplateEvent::fire(DefautThemeEvents::BODY_START);?>

<?php if (Yii::app()->hasModule('menu')): ?>
    <?php $this->widget('application.modules.menu.widgets.MenuWidget', ['name' => 'top-menu']); ?>
<?php endif; ?>
<!-- container -->
<div class='container'>
    <!-- flashMessages -->
    <?php $this->widget('yupe\widgets\YFlashMessages'); ?>
    <!-- breadcrumbs -->
    <?php $this->widget(
        'bootstrap.widgets.TbBreadcrumbs',
        [
            'links' => $this->breadcrumbs,
        ]
    );?>
    <div class="row">
        <!-- content -->
        <section class="col-sm-9 content">
            <?= $content; ?>
        </section>
        <!-- content end-->

        <!-- sidebar -->
        <aside class="col-sm-3 sidebar">
            <?php if (Yii::app()->hasModule('blog')): ?>
                <?php Yii::import('application.modules.blog.BlogModule'); ?>
                <p>
                    <?=
                    CHtml::link(
                        "<i class='glyphicon glyphicon-pencil'></i> " . Yii::t('BlogModule.blog', 'Add a post'),
                        ['/blog/publisher/write'],
                        ['class' => 'btn btn-success', 'style' => 'width: 100%;']
                    );
                    ?>
                </p>
            <?php endif; ?>
            <?php if (Yii::app()->hasModule('cart')): ?>
                <div class="widget shopping-cart-widget" id="shopping-cart-widget">
                    <?php $this->widget('application.modules.cart.widgets.ShoppingCartWidget'); ?>
                </div>
            <?php endif; ?>

            <div class="widget blogs-widget">

                <?php $this->widget(
                    'yupe\widgets\RandomDataWidget',
                    [
                        'data' => [
                            CHtml::link(
                                CHtml::image(
                                    $mainAssets . '/images/amylabs.png',
                                    'amylabs - разработка на Юпи! и Yii !',
                                    ['style' => 'width: 100%']
                                ),
                                'http://amylabs.ru?from=yupe-rb',
                                ['title' => 'amylabs - разработка на Юпи! и Yii !', 'target' => '_blank']
                            ),
                            CHtml::link(
                                CHtml::image(
                                    $mainAssets . '/images/yupe-business.jpg',
                                    'Разработка и запуск интернет магазина на Yii и "Юпи!"',
                                    ['style' => 'width: 100%']
                                ),
                                'http://yupe-project.ru/ecommerce?from=yupe-business',
                                [
                                    'title' => 'Разработка и запуск интернет магазина на Yii и "Юпи!"',
                                    'target' => '_blank'
                                ]
                            )
                        ]
                    ]
                ); ?>
            </div>

            <div class="widget">
                <a href="https://www.jetbrains.com/phpstorm/" target="_blank"><?= CHtml::image(
                        $mainAssets . '/images/logo_phpstorm.png'
                    ); ?></a>
            </div>

            <?php if (Yii::app()->getUser()->isAuthenticated()): ?>
                <div class="widget last-login-users-widget">
                    <?php $this->widget('application.modules.user.widgets.ProfileWidget'); ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::app()->hasModule('blog')): ?>
                <div class="widget stream-widget">
                    <?php if($this->beginCache('application.modules.blog.widgets.StreamWidget', ['duration' => $this->yupe->coreCacheTime])):?>
                        <?php $this->widget('application.modules.blog.widgets.StreamWidget', ['cacheTime' => 300]); ?>
                        <?php $this->endCache();?>
                    <?php endif;?>
                </div>

                <div class="widget last-posts-widget">
                    <?php if($this->beginCache('application.modules.blog.widgets.LastPostsWidget', ['duration' => $this->yupe->coreCacheTime])):?>
                        <?php $this->widget(
                            'application.modules.blog.widgets.LastPostsWidget',
                            ['cacheTime' => $this->yupe->coreCacheTime]
                        ); ?>
                        <?php $this->endCache();?>
                    <?php endif;?>
                </div>

                <div class="widget blogs-widget">
                    <?php if($this->beginCache('application.modules.blog.widgets.BlogsWidget', ['duration' => $this->yupe->coreCacheTime])):?>
                        <?php $this->widget(
                            'application.modules.blog.widgets.BlogsWidget',
                            ['cacheTime' => $this->yupe->coreCacheTime]
                        ); ?>
                    <?php $this->endCache();?>
                    <?php endif;?>
                </div>

                <div class="widget tags-cloud-widget">
                    <?php if($this->beginCache('application.modules.blog.widgets.TagCloudWidget', ['duration' => $this->yupe->coreCacheTime])):?>
                        <?php $this->widget('application.modules.blog.widgets.TagCloudWidget', ['limit' => 50]); ?>
                    <?php $this->endCache();?>
                    <?php endif;?>
                </div>
            <?php endif; ?>

            <?php if (Yii::app()->hasModule('feedback')): ?>
                <div class="widget last-questions-widget">
                    <?php $this->widget(
                        'application.modules.feedback.widgets.FaqWidget',
                        ['cacheTime' => $this->yupe->coreCacheTime]
                    ); ?>
                </div>
            <?php endif; ?>

        </aside>
        <!-- sidebar end -->
    </div>
    <!-- footer -->
    <?php $this->renderPartial('//layouts/_footer'); ?>
    <!-- footer end -->
</div>
<div class='notifications top-right' id="notifications"></div>
<!-- container end -->
<?php if (Yii::app()->hasModule('contentblock')): ?>
    <?php $this->widget(
        "application.modules.contentblock.widgets.ContentBlockWidget",
        ["code" => "STAT", "silent" => true]
    ); ?>
<?php endif; ?>

<?php \yupe\components\TemplateEvent::fire(DefautThemeEvents::BODY_END);?>

</body>
</html>
