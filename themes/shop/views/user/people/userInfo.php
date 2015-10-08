<?php
$this->title = [CHtml::encode($user->nick_name), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [
    Yii::t('UserModule.user', 'Users') => ['/user/people/index/'],
    CHtml::encode($user->getfullName()),
];
?>
<div class="main__title grid">
    <h1 class="h2"><?= CHtml::encode($user->getfullName()); ?></h1>
</div>
<div class="main__cart-box grid">
    <div class="fast-order__inputs">
        <div class="column grid-module-2">
            <?php $this->widget('AvatarWidget',
                ['user' => $user, 'imageHtmlOptions' => ['width' => 100, 'height' => 100]]); ?>
        </div>

        <div class="column grid-module-3">
            <i class="fa fa-user"></i> <?= CHtml::link(CHtml::encode($user->getFullName()),
                ['/user/people/userInfo/', 'username' => CHtml::encode($user->nick_name)]); ?>
            <br/>
            <?php if ($user->visit_time): ?>
                <i class="fa fa-clock-o"></i> <?= Yii::t(
                    'UserModule.user',
                    'Last visit {visit_time}',
                    [
                        "{visit_time}" => Yii::app()->dateFormatter->formatDateTime($user->visit_time, 'long', null)
                    ]
                ); ?><br/>
            <?php endif; ?>

            <?php if ($user->location): ?>
                <i class="fa fa-map-marker"></i> <?= CHtml::encode($user->location); ?><br/>
            <?php endif; ?>

            <?php if ($user->site): ?>
                <i class="fa fa-globe"></i> <?= CHtml::link($user->site, $user->site, [
                    'rel' => 'nofollow',
                    'target' => '_blank',
                    'class' => 'dropdown-menu__link'
                ]); ?><br/>
            <?php endif; ?>
        </div>
    </div>

    <div class="fast-order__inputs">
        <?php if ($user->about): { ?>
            <blockquote>
                <p><?= $user->about; ?></p>
            </blockquote>
        <?php } endif; ?>
    </div>

    <?php if (Yii::app()->hasModule('blog')): { ?>
        <div class="fast-order__inputs">
            <?php $this->widget('application.modules.blog.widgets.UserBlogsWidget', ['userId' => $user->id]); ?>
        </div>
    <?php } endif; ?>
</div>