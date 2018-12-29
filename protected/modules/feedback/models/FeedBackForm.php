<?php

/**
 * FeedBackContantsForm форма обратной связи для публичной части сайта
 *
 * @category YupeController
 * @package  yupe.modules.feedback.models
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     https://yupe.ru
 *
 **/
class FeedBackForm extends CFormModel implements IFeedbackForm
{
    /**
     * @var
     */
    public $name;
    /**
     * @var
     */
    public $email;
    /**
     * @var
     */
    public $phone;
    /**
     * @var
     */
    public $theme;
    /**
     * @var
     */
    public $text;
    /**
     * @var
     */
    public $type;
    /**
     * @var
     */
    public $verifyCode;

    /**
     * @return array
     */
    public function rules()
    {
        $module = Yii::app()->getModule('feedback');

        return [
            ['name, email, theme, text', 'required'],
            ['type', 'numerical', 'integerOnly' => true],
            ['name, email, phone', 'length', 'max' => 150],
            ['theme', 'length', 'max' => 250],
            ['email', 'email'],
            [
                'verifyCode',
                'yupe\components\validators\YRequiredValidator',
                'allowEmpty' => !$module->showCaptcha || Yii::app()->getUser()->isAuthenticated(),
            ],
            [
                'verifyCode',
                'captcha',
                'allowEmpty' => !$module->showCaptcha || Yii::app()->getUser()->isAuthenticated(),
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('FeedbackModule.feedback', 'Your name'),
            'email' => Yii::t('FeedbackModule.feedback', 'Email'),
            'phone' => Yii::t('FeedbackModule.feedback', 'Phone'),
            'theme' => Yii::t('FeedbackModule.feedback', 'Topic'),
            'text' => Yii::t('FeedbackModule.feedback', 'Text'),
            'verifyCode' => Yii::t('FeedbackModule.feedback', 'Check code'),
            'type' => Yii::t('FeedbackModule.feedback', 'Type'),
        ];
    }

    /**
     * Список возможных типов:
     *
     * @return array
     */
    public function getTypeList()
    {
        $types = Yii::app()->getModule('feedback')->types;

        if ($types) {
            $types[FeedBack::TYPE_DEFAULT] = Yii::t('FeedbackModule.feedback', 'Default');
        } else {
            $types = [FeedBack::TYPE_DEFAULT => Yii::t('FeedbackModule.feedback', 'Default')];
        }

        return $types;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }
}
