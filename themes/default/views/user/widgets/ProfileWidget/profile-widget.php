<div class="widget prifile-widget">
    <div class="bootstrap-widget">
        <div class="bootstrap-widget-header">
            <i class="icon-user"></i>
            <h3>Мой профиль</h3>
        </div>
        <div class="bootstrap-widget-content">                     
         <div class="row">
                <div class="span2">
                    <a href="<?php echo Yii::app()->createUrl('/user/account/profile/');?>" title="Редактировать профиль">
                        <?php $this->widget('application.modules.user.widgets.AvatarWidget', array('user' => $user, 'noCache' => true)); ?>
                    </a>                    
                </div>
                <div class="span4">
                  <p>
                     <i class="icon-envelope"></i> <?php echo $user->email;?><br>
                     <i class="icon-globe"></i> <?php echo $user->site;?> <br>                     
                     <i class="icon-map-marker"></i> <?php echo $user->location;?> <br>
                   </p>
                </div>  
            </div>              
        </div>
    </div>
</div>