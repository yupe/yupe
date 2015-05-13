<?php Yii::import('application.modules.user.UserModule'); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-user"></i>
            <?= Yii::t('UserModule.user', 'My profile'); ?>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
                <?= CHtml::link(
                    $this->widget(
                        'application.modules.user.widgets.AvatarWidget',
                        ['user' => $user, 'noCache' => true, 'imageHtmlOptions' => ['width' => 100, 'height' => 100]],
                        true
                    ),
                    ['/user/people/userInfo/', 'username' => $user->nick_name],
                    ['title' => Yii::t('UserModule.user', 'User profile')]
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
                            [
                                'label'      => Yii::t('UserModule.user', 'Edit profile'),
                                'icon'       => 'glyphicon glyphicon-pencil',
                                'buttonType' => 'link',
                                'context'    => 'link',
                                'url'        => ['/user/profile/profile/'],
                            ]
                        ); ?>
                    </li>
                    <?php if(Yii::app()->hasModule('notify')):?>
                        <?php $this->widget(
                            'bootstrap.widgets.TbButton',
                            [
                                'label'      => Yii::t('UserModule.user', 'Notify settings'),
                                'icon'       => 'glyphicon glyphicon-pencil',
                                'buttonType' => 'link',
                                'context'    => 'link',
                                'url'        => ['/notify/notify/settings/'],
                            ]
                        ); ?>
                    <?php endif;?>
                    <li>
                        <i class="glyphicon glyphicon-envelope"></i> <?= $user->email; ?>
                    </li>
                    <?php if ($user->site): { ?>
                        <li>
                            <i class="glyphicon glyphicon-globe"></i> <?= $user->site; ?>
                        </li>
                    <?php } endif; ?>
                    <?php if ($user->location): { ?>
                        <li>
                            <i class="glyphicon glyphicon-map-marker"></i> <?= $user->location; ?>
                        </li>
                    <?php } endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
