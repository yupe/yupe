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
}