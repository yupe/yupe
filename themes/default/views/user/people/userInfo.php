<?php
$this->title = [CHtml::encode($user->nick_name), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [
    Yii::t('UserModule.user', 'Users') => ['/user/people/index/'],
    CHtml::encode($user->getfullName()),
];
?>
<div class="row">
    <div class='col-xs-3'>
        <?php $this->widget('AvatarWidget', ['user' => $user, 'imageHtmlOptions' => ['width' => 100, 'height' => 100]]); ?>
    </div>

    <div class='col-xs-6'>
        <i class="glyphicon glyphicon-user"></i> <?= CHtml::link(CHtml::encode($user->getFullName()), ['/user/people/userInfo/', 'username' => CHtml::encode($user->nick_name)]); ?>
        <br/>
        <?php if ($user->visit_time): ?>
            <i class="glyphicon glyphicon-time"></i> <?= Yii::t(
                'UserModule.user',
                'Last visit {visit_time}',
                [
                    "{visit_time}" => Yii::app()->dateFormatter->formatDateTime($user->visit_time, 'long', null)
                ]
            ); ?><br/>
        <?php endif; ?>

        <?php if ($user->location): ?>
            <i class="glyphicon glyphicon-map-marker"></i> <?= CHtml::encode($user->location); ?><br/>
        <?php endif; ?>

        <?php if ($user->site): ?>
            <i class="glyphicon glyphicon-globe"></i> <?= CHtml::link(
                $user->site,
                $user->site,
                ['rel' => 'nofollow', 'target' => '_blank']
            ); ?><br/>
        <?php endif; ?>
    </div>
</div>

<br/>

<div class="row">
    <div class="col-xs-12">
        <?php if ($user->about): { ?>
            <blockquote>
                <p><?= $user->about; ?></p>
            </blockquote>
        <?php } endif; ?>
    </div>
</div>

<?php if (Yii::app()->hasModule('blog')): { ?>
    <div class="row">
        <div class="col-xs-12">
            <?php $this->widget('application.modules.blog.widgets.UserBlogsWidget', ['userId' => $user->id]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <br/>
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#posts" role="tab" data-toggle="tab"><?= Yii::t('BlogModule.blog', 'Last posts'); ?></a></li>
                <li><a href="#comments" role="tab" data-toggle="tab"><?= Yii::t('BlogModule.blog', 'Comments'); ?></a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="posts">
                    <?php $this->widget(
                        'application.modules.blog.widgets.LastPostsWidget',
                        [
                            'view'     => 'lastuserposts',
                            'criteria' => [
                                'condition' => 't.create_user_id = :user_id',
                                'params'    => [
                                    ':user_id' => $user->id
                                ]
                            ]
                        ]
                    ); ?>
                </div>
                <div class="tab-pane" id="comments">
                    <?php $this->widget('application.modules.blog.widgets.UserPostCommentsWidget', ['userId' => $user->id]); ?>
                </div>
            </div>
        </div>
    </div>
<?php } endif; ?>
