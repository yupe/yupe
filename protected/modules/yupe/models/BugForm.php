<?php
/**
 * Класс формы для сообщения об ошибке
 *
 * @category YupeFormModel
 * @package  yupe.modules.yupe.models
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/ 
namespace yupe\models;

use Yii;

class BugForm extends YFormModel
{
    const OTHER_MODULE = 0;

    public $module;
    public $subject;
    public $message;
    public $sendTo;

    /**
     * Правила валидации:
     *
     * @return array of validation rules
     **/
    public function rules()
    {
        return array(
            array('module, subject, message, sendTo', 'required'),
            array('sendTo','email'),
            array('subject', 'length', 'min' => 6, 'max' => 256),
            array('message', 'length', 'min' => 20),
        );
    }

    /**
     * Получаем атрибуты полей
     * 
     * @return array of attributes labels
     */
    public function attributeLabels()
    {
        return array(
            'module'  => Yii::t('YupeModule.yupe', 'Module'),
            'subject' => Yii::t('YupeModule.yupe', 'Theme'),
            'message' => Yii::t('YupeModule.yupe', 'Error description'),
            'sendTo'  => Yii::t('YupeModule.yupe', 'Send to'),
        );
    }

    /**
     * Получаем описания полей
     * 
     * @return array of attributes description
     */
    public function attributeDescriptions()
    {
        return array(
            'module'  => Yii::t('YupeModule.yupe', 'You must select module in which error was found. If error located not in module you must choose "other" and specify component name in topic/description'),
            'subject' => Yii::t('YupeModule.yupe', 'Please type in short form information about error. In which module/component/widget/etc. it was found.'),
            'message' => Yii::t('YupeModule.yupe', 'Please type detailed information about error. How we can reproduce it? In which platform or software version you found it? Other information what can help us. Also you can propose decision of this problem.'),
            'sendTo'  => Yii::t('YupeModule.yupe', 'Please select receiver for this error report'),
        );
    }

    /**
     * Список модулей
     *
     * @return array listing modules
     **/
    public function getModuleList()
    {
        $modulesList = array(
            self::OTHER_MODULE => Yii::t('YupeModule.yupe','Other'),
        );

        foreach (Yii::app()->modules as $key => $value) {
            $key = strtolower($key);
            
            if (!Yii::app()->hasModule($key) || ($module = Yii::app()->getModule($key)) === null) {
                continue;
            }

            $modulesList[$key] = $module->name . ' (' . $module->version . ')';
        }

        return $modulesList;
    }

    /**
     * Список получателей
     *
     * @return array listing recipients
     **/
    public function getSendToList()
    {
        return array(
            'team@yupe.ru' => Yii::t('YupeModule.yupe', 'Yupe development team!'),
        );
    }
}