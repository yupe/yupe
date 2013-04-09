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
    public $langParam         = 'language';
    public $languageInPath    = true;
    public $preferredLanguage = false;

    public function init()
    {
        // Получаем из настроек доступные языки
        $this->languages = explode(",",  $langs = Yii::app()->getModule('yupe')->availableLanguages);
        if (count($this->languages) < 2)
            return parent::init();

        if (isset($this->languages[0]) && !$this->languages[0])
            $this->languages = null;

        // Если указаны - добавляем правила для обработки, иначе ничего не трогаем вообще
        if ($this->languageInPath && is_array($this->languages))
        {
            $lstr=str_replace(',','|',$langs);

            // Добавляем правила для обработки языков
            $r = array();
            foreach ($this->rules as $rule => $p)
                $r[(($rule[0] == '/')
                    ? '/<' . $this->langParam . ':(' . $lstr. ')>'
                    : '<' . $this->langParam . ':(' . $lstr . ')>/'
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
        if (count($this->languages) < 2)
            return parent::createUrl($route, $params, $ampersand);

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

    /**
     * Выполняет очистку адреса от языка
     * @return string обработанную строку адреса
     */
    public function getCleanUrl($url)
    {
        strstr($url, '?')
            ? list($url, $param) = explode("?", $url)
            : $param = false;
        // Убираем homeUrl из адреса
        $url = preg_replace("#^(" . Yii::app()->request->scriptUrl . "|" . Yii::app()->request->baseUrl . ")#", '', $url);
        // Убираем из пути адреса языковой параметр
        if ($url != '' && $url != '/')
        {
            if ($url[0] == '/')
                $url = substr($url, 1);
            if ($url[strlen($url) - 1] != '/')
                $url .= '/';
            $url = preg_replace("#^(" . implode("|", $this->languages) . ")/#", '', $url);
        }
        // Убираем косую черту в конце пути для единоообразия
        if ($url != '' && $url[strlen($url) - 1] == '/')
            $url = substr($url, 0, strlen($url) - 1);
        // Убираем из GET-парамметров адреса языковой парамметр
        if ($param != false)
        {
            parse_str($param, $param);
            if (isset($param[$this->langParam]))
                unset($param[$this->langParam]);
            if ($param != array())
                $url .= '?' . http_build_query($param);
        }
        return $url;
    }

    /**
     * При принудительном изменении языка, определяет как добавлять язык
     * @return string обработанную строку адреса
     * первый парамметр url должен быть очищен от языкового парамметра с помощью getCleanUrl.
     */
    public function replaceLangUrl($url, $lang = false)
    {
        if ($lang)
            $url = ($this->languageInPath)
                ? $lang . ($url != '' ? '/' . $url : '')
                : $url . (strstr($url, '?') ? '&' : '?') . $this->langParam . '=' . $lang;
        return $url;
    }
}