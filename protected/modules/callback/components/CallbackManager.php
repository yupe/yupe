<?php

/**
 * Class CallbackManager
 */
class CallbackManager extends CApplicationComponent
{
    /** @var CallbackController */
    private $view;

    /**
     * @var
     */
    private $mailer;

    /** @var CallbackModule */
    private $module;

    /**
     * @var
     */
    private $adminEmail;

    /**
     * @var
     */
    private $timeLimitKey = 'Callback_temporarly_block';

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->view = Yii::app()->getController();
        $this->mailer = Yii::app()->mail;
        $this->module = Yii::app()->getModule('callback');
        $this->adminEmail = Yii::app()->getModule('yupe')->email;
    }

    /**
     * Add callback request to DB
     *
     * @param array $data Form data
     * @param string $referrer Referrer page url
     * @return bool
     */
    public function add($data, $referrer = null)
    {
        if (!$data) {
            return false;
        }
        if ($this->module->sentTimeLimit) {
            if (!$this->hasTimeLimitForSending()){
                $this->setTimeLimitForSending();
            } else {
                return new Exception(Yii::t('CallbackModule.callback', 'Resending will be available in a few minutes later'));
            }
        }

        $model = new Callback();
        $model->setAttributes($data);
        $model->url = $referrer;

        if ($model->save()) {
            Yii::app()->eventManager->fire(
                CallbackEvents::ADD,
                new CallbackAddEvent($model)
            );

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
        $from = $this->module->notifyEmailFrom ?: $this->adminEmail;
        $to = $this->module->getNotifyTo();
        $theme = Yii::t('CallbackModule.callback', 'Callback request');
        $body = $this->view->renderPartial('/callback/email/request', ['model' => $model], true);

        foreach ($to as $email) {
            $this->mailer->send($from, $email, $theme, $body);
        }

        return true;
    }

    /**
     * @param int $expireTime in seconds
     */
    private function setTimeLimitForSending()
    {
        Yii::app()->getUser()->setState($this->timeLimitKey, time());
    }

    /**
     * @param int $expireTime in seconds
     */
    private function hasTimeLimitForSending()
    {
        $expire_time = time() - $this->module->sentTimeLimit;
        $settedTemporarlyBlockTime = Yii::app()->getUser()->getState($this->timeLimitKey);

        return $settedTemporarlyBlockTime ? ($settedTemporarlyBlockTime > $expire_time) : false;
    }

}