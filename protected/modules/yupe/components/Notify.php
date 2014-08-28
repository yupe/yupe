<?php
namespace yupe\components;

use Yii;
use CApplicationComponent;
use User;

class Notify extends CApplicationComponent
{
    /**
     * @var
     */
    public $mail;

    /**
     *
     */
    public function init()
    {
        $mailer = Yii::createComponent($this->mail);
        $mailer->init();
        $this->setMail($mailer);
        parent::init();
    }

    /**
     * @param Mail $mail
     */
    public function setMail(Mail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * @param  User $user
     * @param $theme
     * @param $view
     * @param $data
     * @return mixed
     */
    public function send(User $user, $theme, $view, $data)
    {
        $data['user'] = $user;

        return $this->mail->send(
            Yii::app()->getModule('user')->notifyEmailFrom,
            $user->email,
            $theme,
            Yii::app()->getController()->renderPartial($view, $data, true)
        );
    }
}
