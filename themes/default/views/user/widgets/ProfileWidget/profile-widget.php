<div class="widget prifile-widget">
    <div class="bootstrap-widget">
        <div class="bootstrap-widget-header">
            <i class="icon-user"></i>

            <h3>Мой профиль</h3>
        </div>
        <div class="bootstrap-widget-content">
            <div class="pull-left">
                <a href="<?php echo Yii::app()->createUrl('/user/account/profile/');?>" title="Редактировать профиль">
                    <?php $this->widget('AvatarWidget', array('user' => $user, 'noCache' => true)); ?>
                </a>
            </div>
            <?php echo CHtml::link($user->nick_name,array('/user/account/profile/'));?>
        </div>
    </div>
</div>