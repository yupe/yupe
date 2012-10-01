<?php
/*
 * LangUrlManager - альтернативный менеджер урлов с поддержкой языков
 * при инициализации добавляет к существующим правилам маршрутизации
 * правила для выбора языков в началае пути.
 * Т.о. /page/<slug> к примеру становится /<language>/page/<slug>.
 * Добавленный параметр используется в LanguageBehavior
 */
class LangUrlManager extends CUrlManager
{
    public $languages;
    public $langParam = 'language';

    public function init()
    {
        // Получаем из настроек доступные языки
        $yupe = Yii::app()->getModule('yupe');
        $this->languages = explode(",", $yupe->availableLanguages);
        if (isset($this->languages[0]) && !$this->languages[0])
            $this->languages = null;

        // Если указаны - добавляем правила для обработки, иначе ничего не трогаем вообще
        if (is_array($this->languages))
        {
            // Добавляем правила для обработки языков
            $r = array();

            foreach ($this->rules as $rule => $p)
                $r[(($rule[0] == '/')
                        ? '/<' . $this->langParam . ':\w{2}>'
                        : '<' . $this->langParam . ':\w{2}>/'
                ) . $rule] = $p;

            $this->rules = array_merge($r, $this->rules);

            $p = parent::init();
            $this->processRules();
            return $p;
        }
        else
            return parent::init();
    }

    public function createUrl($route, $params = array(), $ampersand = '&')
    {
        // Если указаны языки, дописываем указанный язык
        if (is_array($this->languages))
        {
            // Если язык не указан - берем текущий
            if (!isset($params[$this->langParam]))
                $params[$this->langParam] = Yii::app()->language;

            // Если указан "нативный" язык и к тому же он текущий  - делаем URL без него, т.к. он соответсвует пустому пути
            if ((Yii::app()->sourceLanguage == $params[$this->langParam]) && ($params[$this->langParam] == Yii::app()->language))
                unset($params[$this->langParam]);

        }
        return parent::createUrl($route, $params, $ampersand);
    }

    public function getCleanUrl($url)
    {
        if (in_array($url, $this->languages))
            return "/";

        $r = join("|", $this->languages);
        $url = (!isset($url[0]) || ($url[0] != '/')) ? '/' . $url : preg_replace("/^($r)\//", "", $url);

        return $url;
    }
}