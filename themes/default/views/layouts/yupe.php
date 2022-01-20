<?php $this->beginContent('//layouts/main'); ?>
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
        <a target="_new" href="https://timeweb.com/ru/?i=28284&a=142"><img style="border:0px;" src="https://wm.timeweb.ru/images/posters/200x300/200x300-10-anim.gif"></a>
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

<?php $this->endContent(); ?>
