<?php
$this->pageTitle = CHtml::encode($user->nick_name);
$this->breadcrumbs = array(
    Yii::t('UserModule.user', 'Users') => array('/user/people/index/'),
    CHtml::encode($user->getfullName()),
);
?>
<div class="row">
    <div class='col-xs-3'>
        <?php $this->widget('AvatarWidget', array('user' => $user)); ?>
    </div>

    <div class='col-xs-6'>
        <i class="glyphicon glyphicon-user"></i> <?php echo CHtml::link(
            CHtml::encode($user->getFullName()),
            array('/user/people/userInfo/', 'username' => CHtml::encode($user->nick_name))
        ); ?>
        <br/>
        <?php if ($user->last_visit): { ?>
            <i class="glyphicon glyphicon-time"></i> <?php echo Yii::t(
                'UserModule.user',
                'Last visit {last_visit}',
                array(
                    "{last_visit}" => Yii::app()->dateFormatter->formatDateTime($user->last_visit, 'long', null)
                )
            );?><br/>
        <?php } endif; ?>

        <?php if ($user->location): { ?>
            <i class="glyphicon glyphicon-map-marker"></i> <?php echo CHtml::encode($user->location); ?><br/>
        <?php } endif; ?>

        <?php if ($user->site): { ?>
            <i class="glyphicon glyphicon-globe"></i> <?php echo CHtml::link(
                $user->site,
                $user->site,
                array('rel' => 'nofollow', 'target' => '_blank')
            ); ?><br/>
        <?php } endif; ?>
    </div>
</div>

<br/>

<div class="row">
    <div class="col-xs-12">
        <?php if ($user->about): { ?>
            <blockquote>
                <p><?php echo $user->about; ?></p>
            </blockquote>
        <?php } endif; ?>
    </div>
</div>

<?php if (Yii::app()->hasModule('blog')): { ?>
    <div class="row">
        <div class="col-xs-12">
            <?php $this->widget(
                'application.modules.blog.widgets.UserBlogsWidget',
                array(
                    'userId' => $user->id
                )
            ); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php $this->widget(
                'application.modules.blog.widgets.LastPostsWidget',
                array(
                    'view'     => 'lastuserposts',
                    'criteria' => array(
                        'condition' => 't.create_user_id = :user_id',
                        'params'    => array(
                            ':user_id' => $user->id
                        )
                    )
                )
            ); ?>
        </div>
    </div>
<?php } endif; ?>
