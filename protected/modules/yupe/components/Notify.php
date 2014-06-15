<?php
namespace yupe\components;

use Yii;
use CApplicationComponent;
use User;

class Notify extends CApplicationComponent
{
    public $mail;

    public function init()
    {
        $mailer = Yii::createComponent($this->mail);
        $mailer->init();
        $this->setMail($mailer);
        parent::init();
    }

    public function setMail(Mail $mail)
    {
        $this->mail = $mail;
    }

    public function send(User $user, $theme, $view, $data)
    {
        $data['user'] = $user; // Хочу в шаблоне письма использовать имя пользователя или хотя бы nick_name 
        return $this->mail->send(
            Yii::app()->getModule('user')->notifyEmailFrom,
            $user->email,
            $theme,
            Yii::app()->controller->renderPartial($view, $data, true)
        );
    }
}
