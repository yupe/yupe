<?php
/**
 * Класс формы для сообщения об ошибке
 *
 * @category YupeFormModel
 * @package  YupeCMS
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/ 
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
            'module'  => Yii::t('YupeModule.yupe', 'Модуль'),
            'subject' => Yii::t('YupeModule.yupe', 'Тема'),
            'message' => Yii::t('YupeModule.yupe', 'Описание ошибки'),
            'sendTo'  => Yii::t('YupeModule.yupe', 'Получатель'),
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
            'module'  => Yii::t('YupeModule.yupe', 'Необходимо выбрать модуль, в котором замечена ошибка. Если ошибка касается не модуля, а какого-то компонента, необходимо выбрать "другой" и в теме/описании написать касательно какого компонента данный отчёт об ошибке.'),
            'subject' => Yii::t('YupeModule.yupe', 'Укажите в краткой форме касательно чего этот отчёт об ошибке. Возможно указание какого именно компонента/модуля/виджета касается данный отчёт.'),
            'message' => Yii::t('YupeModule.yupe', 'Опишите в полной форме, что за ошибка возникает, как её воспроизвести (желательно подробная инструкция, так как некоторые ошибки специфичны для платформ/настроек окружения), также, возможно у вас есть решение данной проблемы, будем рады получить любую информацию, которая поможет в решении или воспроизведении данной ошибки.'),
            'sendTo'  => Yii::t('YupeModule.yupe', 'Укажите получателья данного отчёта об ошибке.'),
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
            self::OTHER_MODULE => Yii::t('YupeModule.yupe','Другое'),
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
            'team@yupe.ru' => Yii::t('YupeModule.yupe', 'Команда разработчиков Юпи!'),
        );
    }


}