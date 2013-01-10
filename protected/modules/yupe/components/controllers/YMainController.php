<?php
/**
 * Содержит общие функции для панели управления и фронтенда
 *
 * @author aopeykin
 */
class YMainController extends Controller
{
    public $yupe;

    public function isMultilang()
    {
        return isset(Yii::app()->urlManager->languages) && is_array(Yii::app()->urlManager->languages);
    }

    public function init()
    {
        parent::init();
        $this->yupe = Yii::app()->getModule('yupe');
    }

    public function widget($className, $properties = array(), $captureOutput = false)
    {
        if (stripos($className, 'application.modules.', 0) !== false)
        {
            //@TODO попробовать без регулярки
            $module = preg_replace('/^application\.modules\.([^\.]*).*$/', '$1', $className);

            if (Yii::app()->getModule($module) == NULL)
            {
                echo Yii::t('YupeModule.yupe', 'Виджет "{widget}" не найден! Подключите модуль "{module}" !',array(
                    '{widget}' => $className,
                    '{module}' => $module
                ));
                return;
            }
        }
        parent::widget($className, $properties, $captureOutput);
    }
}