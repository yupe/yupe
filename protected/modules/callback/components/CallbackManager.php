<?php
class CallbackManager extends CApplicationComponent
{
    /** @var CallbackController */
    private $view;

    private $mailer;

    /** @var CallbackModule */
    private $module;

    private $adminEmail;

    public function init()
    {
        $this->view = Yii::app()->controller;
        $this->mailer = Yii::app()->mail;
        $this->module = Yii::app()->getModule('callback');
        $this->adminEmail = Yii::app()->getModule('yupe')->email;
    }

    /**
     * Add callback request to DB
     *
     * @param $data
     * @return bool
     */
    public function add($data)
    {
        if(!$data) {
            return false;
        }

        $model = new Callback();
        $model->setAttributes($data);

        if($model->save()) {
            $this->sendNotification($model);
            return true;
        }

        return false;
    }

    /**
     * Send notification to managers
     *
     * @param Callback $model
     * @return bool
     */
    private function sendNotification(Callback $model)
    {
        $from = $this->module->notifyEmailFrom ? : $this->adminEmail;
        $to = $this->module->getNotifyTo();
        $theme = Yii::t('CallbackModule.callback', 'Callback request');
        $body = $this->view->renderPartial('/callback/email/request', ['model' => $model], true);

        foreach ($to as $email) {
            $this->mailer->send($from, $email, $theme, $body);
        }

        return true;
    }
}