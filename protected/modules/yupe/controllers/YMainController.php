<?php
/**
 * Содержит общие функции для админки и фронтенда
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
        $this->yupe = Yii::app()->getModule('yupe');

        parent::init();
    }
}