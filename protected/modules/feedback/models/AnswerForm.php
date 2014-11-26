<?php

/**
 * AnswerForm форма для ответа на сообщение из панели управления
 *
 * @category YupeController
 * @package  yupe.modules.feedback.models
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/
class AnswerForm extends CFormModel
{
    public $answer;
    public $is_faq;
    public $email;

    public function rules()
    {
        return [
            ['answer', 'required'],
            ['is_faq', 'in', 'range' => [0, 1]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'answer' => Yii::t('FeedbackModule.feedback', 'Reply'),
            'is_faq' => Yii::t('FeedbackModule.feedback', 'In FAQ'),
        ];
    }
}
