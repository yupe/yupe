<?php
return array(
    'module'    => array(
        'class' => 'application.modules.notify.NotifyModule',
    ),
    'import'    => array(
        'application.modules.notify.listeners.*',
    ),
    'component' => array(
        'eventManager'   => array(
            'class'  => 'yupe\components\EventManager',
            'events' => array(
                'user.success.activate' => array(
                    array('UserActivationListener', 'onUserActivate')
                ),
                'comment.add.success' => array(
                    array('NotifyNewCommentListener', 'onNewComment')
                ),
            )
        )
    ),
    'rules' => array(
        '/profile/notify' => 'notify/notify/settings'
    ),
);
