<?php

/**
 * Class FeedbackService
 */
class FeedbackService extends CApplicationComponent
{
    /**
     * @param FeedBackForm $form
     * @param FeedbackModule $module
     * @return bool
     */
    public function send(FeedBackForm $form, FeedbackModule $module)
    {
        $backEnd = array_unique($module->backEnd);

        $success = true;

        if (is_array($backEnd)) {

            foreach ($backEnd as $storage) {

                $sender = new $storage(Yii::app()->mail, $module);

                if (!$sender->send($form)) {
                    $success = false;
                }
            }
        }

        if (true === $success) {
            Yii::app()->eventManager->fire(FeedbackEvents::SEND_SUCCESS, new FeedbackSendEvent(
                Yii::app()->getUser(),
                $form
            ));
        }

        return $success;
    }
}