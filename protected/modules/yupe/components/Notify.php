<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aopeykin
 * Date: 20.11.13
 * Time: 10:02
 * To change this template use File | Settings | File Templates.
 */

namespace yupe\components;

use Yii;
use CVarDumper;
use CApplicationComponent;
use User;

class Notify extends CApplicationComponent
{
    public $mail;

    public function init()
    {
        $this->setMail(Yii::createComponent($this->mail));

        parent::init();
    }

    public function setMail(Mail $mail)
    {
        $this->mail = $mail;
    }

    public function send(User $user, $theme, $view, $data)
    {
        $body = Yii::app()->controller->renderPartial($view, $data, true);

        return $this->mail->send(
            Yii::app()->getModule('user')->notifyEmailFrom,
            $user->email,
            $theme,
            $body
        );
    }
}