<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LangUrlManager
 *
 * @author Ekstazi
 * @ver 1.2
 */
class LangUrlManager extends CUrlManager{
    public $languages=array('en');
    public $langParam='lang';

    public function parsePathInfo($pathInfo)
    {
        parent::parsePathInfo($pathInfo);
        
        $userLang=Yii::app()->getRequest()->getPreferredLanguage();
        //if language pass via url use it
        if(isset($_GET[$this->langParam])&&in_array($_GET[$this->langParam],$this->languages)){
            Yii::app()->language=$_GET[$this->langParam];
        //else if preffered language is allowed
        }elseif(in_array($userLang,$this->languages)) {
            Yii::app()->language=$userLang;
        //else use the first language from the list
        }else Yii::app()->language=$this->languages[0];
    }
    //put your code here
    public function createUrl($route, $params=array(), $ampersand='&'){
        if(!isset($params[$this->langParam])) $params[$this->langParam]=Yii::app()->language;
        return parent::createUrl($route,$params,$ampersand);
    }
    //put your code here
}