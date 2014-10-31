<?php

/**
 * Class UserActivationListener
 */

Yii::import('application.modules.notify.models.NotifySettings');

class UserActivationListener
{
    /**
     * @param UserActivateEvent $event
     */
    public static function onUserActivate(UserActivateEvent $event)
    {
        $user = $event->getUser();

        if (null !== $user) {
            $notify = new NotifySettings;
            $notify->user_id = $user->id;
            $notify->save();
        }
    }
} 
