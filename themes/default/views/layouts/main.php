<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
<head prefix="og: http://ogp.me/ns#
    fb: http://ogp.me/ns/fb#
    article: http://ogp.me/ns/article#">
    <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1">
    <meta charset="<?php echo Yii::app()->charset; ?>"/>
    <meta name="keywords" content="<?php echo CHtml::encode($this->keywords); ?>"/>
    <meta name="description" content="<?php echo CHtml::encode($this->description); ?>"/>
    <meta property="og:title" content="<?php echo CHtml::encode($this->pageTitle); ?>"/>
    <meta property="og:description" content="<?php echo CHtml::encode($this->description); ?>"/>
    <?php
    $mainAssets = Yii::app()->getTheme()->getAssetsUrl();

    Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/main.css');
    Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/flags.css');
    Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/yupe.css');
    Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/blog.js');
    Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/bootstrap-notify.js');
    Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/jquery.li-translit.js');
    Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/comments.js');
    ?>
    <script type="text/javascript">
        var yupeTokenName = '<?php echo Yii::app()->getRequest()->csrfTokenName;?>';
        var yupeToken = '<?php echo Yii::app()->getRequest()->csrfToken;?>';
    </script>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="http://yandex.st/highlightjs/8.2/styles/github.min.css">
    <script src="http://yastatic.net/highlightjs/8.2/highlight.min.js"></script>
</head>

<body>
<?php if (Yii::app()->hasModule('menu')): { ?>
    <?php $this->widget('application.modules.menu.widgets.MenuWidget', array('name' => 'top-menu')); ?>
<?php } endif; ?>
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
        <section class="col-sm-9 content">
            <?php echo $content; ?>
        </section>
        <!-- content end-->

        <!-- sidebar -->
        <aside class="col-sm-3 sidebar">
            <?php if (Yii::app()->hasModule('blog')): ?>
                <?php Yii::import('application.modules.blog.BlogModule');?>
                <p>
                    <?= CHtml::link(
                        "<i class='glyphicon glyphicon-pencil'></i> " . Yii::t('BlogModule.blog', 'Add a post'),
                        ['/blog/publisher/write'],
                        ['class' => 'btn btn-success', 'style' => 'width: 100%;']);
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
                    array(
                        'data' => array(
                            CHtml::link(
                                CHtml::image(
                                    $mainAssets . '/images/amylabs.png',
                                    'amylabs - разработка на Юпи! и Yii !',
                                    array('style' => 'width: 100%')
                                ),
                                'http://amylabs.ru?from=yupe-rb',
                                array('title' => 'amylabs - разработка на Юпи! и Yii !', 'target' => '_blank')
                            ),
                            CHtml::link(
                                CHtml::image(
                                    $mainAssets . '/images/yupe-shop.png',
                                    'Разработка и запуск интернет магазина на Yii и "Юпи!"',
                                    array('style' => 'width: 100%')
                                ),
                                'http://yupe-project.ru/ecommerce?from=yupe-rb',
                                array('title' => 'Разработка и запуск интернет магазина на Yii и "Юпи!"', 'target' => '_blank')
                            ),
                        )
                    )
                ); ?>
            </div>

            <?php if (Yii::app()->user->isAuthenticated()): ?>
                <div class="widget last-login-users-widget">
                    <?php $this->widget('application.modules.user.widgets.ProfileWidget'); ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::app()->hasModule('blog')): ?>
                <div class="widget stream-widget">
                    <?php $this->widget('application.modules.blog.widgets.StreamWidget', array('cacheTime' => 300)); ?>
                </div>

                <div class="widget last-posts-widget">
                    <?php $this->widget(
                        'application.modules.blog.widgets.LastPostsWidget',
                        array('cacheTime' => $this->yupe->coreCacheTime)
                    ); ?>
                </div>

                <div class="widget blogs-widget">
                    <?php $this->widget(
                        'application.modules.blog.widgets.BlogsWidget',
                        array('cacheTime' => $this->yupe->coreCacheTime)
                    ); ?>
                </div>

                <div class="widget tags-cloud-widget">
                    <?php $this->widget(
                        'application.modules.blog.widgets.TagCloudWidget',
                        array('cacheTime' => $this->yupe->coreCacheTime, 'model' => 'Post', 'count' => 50)
                    ); ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::app()->hasModule('feedback')): ?>
                <div class="widget last-questions-widget">
                    <?php $this->widget(
                        'application.modules.feedback.widgets.FaqWidget',
                        array('cacheTime' => $this->yupe->coreCacheTime)
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
<?php if (Yii::app()->hasModule('contentblock')): { ?>
    <?php $this->widget(
        "application.modules.contentblock.widgets.ContentBlockWidget",
        array("code" => "STAT", "silent" => true)
    ); ?>
<?php } endif; ?>
</body>
</html>
