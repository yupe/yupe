<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of YMainController
 *
 * @author aopeykin
 */
class YMainController extends Controller
{
    public $yupe;

    public function isMultilang()
    {
        return isset(
            Yii::app()->urlManager->languages) &&
            is_array(Yii::app()->urlManager->languages) &&
            count(Yii::app()->urlManager->languages
        );
    }

    public function init()
    {
        $this->yupe = Yii::app()->getModule('yupe');

        parent::init();
    }
}