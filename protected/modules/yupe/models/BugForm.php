<?php
/**
 * Класс формы для сообщения об ошибке
 *
 * @category YupeFormModel
 * @package  YupeCMS
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.1 (dev)
 * @link     http://yupe.ru
 *
 **/ 
class BugForm extends YFormModel
{
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
            array('subject', 'length', 'min' => 6, 'max' => '128'),
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
            'module'  => Yii::t('YupeModule.yupe', 'Модуль'),
            'subject' => Yii::t('YupeModule.yupe', 'Тема'),
            'message' => Yii::t('YupeModule.yupe', 'Описание ошибки'),
            'sendTo'  => Yii::t('YupeModule.yupe', 'Получатель'),
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
            0 => 'Другой',
        );

        foreach (Yii::app()->modules as $key => $value) {
            $key = strtolower($key);
            
            if (!Yii::app()->hasModule($key) || ($module = Yii::app()->getModule($key)) === null)
                continue;

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
            'tuxuls@gmail.com' => Yii::t('YupeModule.yupe', 'Комманда разработчиков Юпи!'),
        );
    }


}