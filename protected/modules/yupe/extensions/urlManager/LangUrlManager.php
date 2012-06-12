<?php
/**
 * Description of LangUrlManager
 *
 * @author Ekstazi
 * @ver 1.2
 */
class LangUrlManager extends CUrlManager{
    public $languages;
    public $langParam='lang';

    public function init()
    {
	// Получаем из настроек доступные языки
	$yupe = Yii::app()->getModule('yupe');
        $this-> languages = explode(",",$yupe->availableLanguages);
	$this-> languages || ($this-> languages=array('ru'));

	// Добавляем правила для обработки языков
	$r= array();
	foreach( $this-> rules as $rule=>$p )
		$r[(($rule[0]=='/')?'/<lang:\w{2}>':'<lang:\w{2}>/').$rule]=$p;
	$this-> rules = array_merge($r, $this->rules);

	$p = parent::init();
 	$this->processRules();
	return $p;

    }

    public function parsePathInfo($pathInfo)
    {
        parent::parsePathInfo($pathInfo);
        $userLang=Yii::app()->getRequest()->getPreferredLanguage();

        // Если язык передали через запрос
        if(isset($_GET[$this->langParam])&&in_array($_GET[$this->langParam],$this->languages))
            Yii::app()->language=$_GET[$this->langParam];
        // иначе попробуем угадать какой нужен
        elseif(in_array($userLang,$this->languages)) {
            Yii::app()->language=$userLang;
        // иначе первый в списке
        }else Yii::app()->language=$this->languages[0];
    }

    public function createUrl($route, $params=array(), $ampersand='&')
    {
	
        if(!isset($params[$this->langParam]))
		$params[$this->langParam]=Yii::app()->language;
	if ( Yii::app()->sourceLanguage == $params[$this->langParam] ) 
		unset($params[$this->langParam]);
        return parent::createUrl($route,$params,$ampersand);
    }

    public function parseUrl($request)
    {
	if($this->getUrlFormat()===self::PATH_FORMAT)
	{
		$pi=$request->getPathInfo();
		$l = substr($pi,0,2);
		if ( (strlen($l)==2) && in_array($l,$this->languages) && ( $l==Yii::app()-> sourceLanguage ))
			Yii::app()-> request-> redirect(substr($pi,2));
				                                        
	}
    	return parent::parseUrl($request);
    }
}