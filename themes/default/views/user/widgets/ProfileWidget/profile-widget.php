<?php Yii::import('application.modules.user.UserModule'); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-user"></i>
            <?php echo Yii::t('UserModule.user', 'My profile'); ?>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
                <?php echo CHtml::link(
                    $this->widget(
                        'application.modules.user.widgets.AvatarWidget',
                        array('user' => $user, 'noCache' => true),
                        true
                    ),
                    array('/user/people/userInfo/', 'username' => $user->nick_name),
                    array('title' => Yii::t('UserModule.user', 'User profile'))
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <p>
                <ul class="user-info">
                    <li>
                        <?php $this->widget(
                            'bootstrap.widgets.TbButton',
                            array(
                                'label'      => Yii::t('UserModule.user', 'Edit profile'),
                                'icon'       => 'glyphicon glyphicon-pencil',
                                'buttonType' => 'link',
                                'context'    => 'link',
                                'url'        => array('/user/account/profile/'),
                            )
                        ); ?>
                    </li>
                    <?php if(Yii::app()->hasModule('notify')):?>
                        <?php $this->widget(
                            'bootstrap.widgets.TbButton',
                            array(
                                'label'      => Yii::t('UserModule.user', 'Notify settings'),
                                'icon'       => 'glyphicon glyphicon-pencil',
                                'buttonType' => 'link',
                                'context'    => 'link',
                                'url'        => array('/notify/notify/settings/'),
                            )
                        ); ?>
                    <?php endif;?>
                    <li>
                        <i class="glyphicon glyphicon-envelope"></i> <?php echo $user->email; ?>
                    </li>
                    <?php if ($user->site): { ?>
                        <li>
                            <i class="glyphicon glyphicon-globe"></i> <?php echo $user->site; ?>
                        </li>
                    <?php } endif; ?>
                    <?php if ($user->location): { ?>
                        <li>
                            <i class="glyphicon glyphicon-map-marker"></i> <?php echo $user->location; ?>
                        </li>
                    <?php } endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
