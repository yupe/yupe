<?php Yii::import('application.modules.user.UserModule'); ?>
<div class="widget prifile-widget">
    <div class="bootstrap-widget">
        <div class="yupe-widget-header">
            <i class="icon-user"></i>
            <h3><?php echo Yii::t('UserModule.user', 'My profile'); ?></h3>
        </div>
        <div class="yupe-widget-content">
            <div class="row-fluid">
                <div class="span12">
                    <?php echo CHtml::link(
                        $this->widget('application.modules.user.widgets.AvatarWidget', array('user' => $user, 'noCache' => true), true),
                        array('/user/people/userInfo/', 'username' => $user->nick_name),
                        array('title' => Yii::t('UserModule.user', 'User profile'))
                    ); ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                  <p>
                    <ul class="user-info">
                        <li>
                            <?php $this->widget(
                                'bootstrap.widgets.TbButton', array(
                                    'label' => Yii::t('UserModule.user', 'Edit profile'),
                                    'icon'  => 'pencil',
                                    'type'  => 'link',
                                    'url'   => array('/user/account/profile/'),
                                )
                            ); ?>
                        </li>
                        <li>
                            <i class="icon-envelope"></i> <?php echo $user->email;?>
                        </li>
                        <?php if($user->site):?>
                            <li>
                                <i class="icon-globe"></i> <?php echo $user->site;?>
                            </li>
                        <?php endif;?>
                        <?php if($user->location):?>
                            <li>
                                <i class="icon-map-marker"></i> <?php echo $user->location;?>
                            </li>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>