<?php Yii::import('application.modules.user.UserModule'); ?>
<div class="widget prifile-widget">
    <div class="bootstrap-widget">
        <div class="bootstrap-widget-header">
            <i class="icon-user"></i>
            <h3><?php echo Yii::t('UserModule.user', 'My profile'); ?></h3>
        </div>
        <div class="bootstrap-widget-content">
            <div class="row-fluid">
                <div class="span12">
                    <a href="<?php echo Yii::app()->createUrl('/user/account/profile/');?>" title="<?php echo Yii::t('UserModule.user', 'Edit profile'); ?>">
                        <?php $this->widget('application.modules.user.widgets.AvatarWidget', array('user' => $user, 'noCache' => true)); ?>
                    </a>
                </div>
            </div>
            <br />
            <div class="row-fluid">
                <div class="span12">
                  <p>
                     <i class="icon-envelope"></i> <?php echo $user->email;?><br>
                     <?php if($user->site):?>
                         <i class="icon-globe"></i> <?php echo $user->site;?> <br>
                     <?php endif;?>
                     <?php if($user->location):?>
                         <i class="icon-map-marker"></i> <?php echo $user->location;?> <br>
                     <?php endif;?>
                   </p>
                </div>
            </div>
        </div>
    </div>
</div>