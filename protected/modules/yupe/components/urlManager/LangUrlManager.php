<?php
/**
 * LangUrlManager - альтернативный менеджер урлов с поддержкой языков
 * при инициализации добавляет к существующим правилам маршрутизации правила для выбора языков в начале пути.
 * То есть, если рассматривать на примере - /<controller>/<index>,
 * то в случае обработки мы получим дополнительное правило:
 * /<language>/<controller>/<action>.
 * Добавленный параметр используется в LanguageBehavior
 *
 * @category YupeComponent
 * @package  yupe.modules.yupe.components.urlManager
 * @author   YupeTeam <support@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     https://yupe.ru
 */
namespace yupe\components\urlManager;

use CUrlManager;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Yii;
use YupeModule;

/**
 * Class LangUrlManager
 * @package yupe\components\urlManager
 */
class LangUrlManager extends CUrlManager
{
    /**
     * @var string
     */
    public $langParam = 'language';
    /**
     * @var string
     */
    protected $_defaultLang;
    /**
     * @var string
     */
    protected $_currentLang;
    /**
     * @var string
     */
    protected $_langFromUrl;
    /**
     * @var string
     */
    protected $_langFromCookie;
    /**
     * @var array
     */
    protected $_languages;
    /**
     * @var YupeModule
     */
    protected $yupe;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->yupe = Yii::app()->getModule('yupe');
        $languages = $this->getAvailableLanguages();

        if ('path' === $this->urlFormat && count($languages) > 1) {

            $languages = implode('|', $languages);
            $rules = [];
            $langPattern = '/<'.$this->langParam.':('.$languages.')>/';
            foreach ($this->rules as $pattern => $route) {
                if (is_array($route)) {
                    if (isset($route['pattern'])) {
                        $route['pattern'] = $langPattern.ltrim($route['pattern'], '/');
                        $rules[] = $route;
                    }
                } else {
                    $pattern = $langPattern.ltrim($pattern, '/');
                    $rules[$pattern] = $route;
                }
            }

            $this->rules = array_merge($rules, $this->rules);
        }

        parent::init();
    }

    /**
     * @return array
     */
    public function getAvailableLanguages()
    {
        if (null === $this->_languages) {
            $this->_languages = explode(',', $this->yupe->availableLanguages);
        }

        return $this->_languages;
    }

    /**
     * @return string
     */
    public function getDefaultLang()
    {
        if (null === $this->_defaultLang) {
            $this->_defaultLang = $this->isBackend()
                ? $this->yupe->defaultBackendLanguage
                : $this->yupe->defaultLanguage;
        }

        return $this->_defaultLang;
    }

    /**
     * @return null|string
     */
    public function getCurrentLang()
    {
        if (null === $this->_currentLang) {
            $language = $this->getLangFromUrl();

            if (null === $language) {
                $language = $this->getLangFromCookie() ?: $this->getDefaultLang();
            }

            $this->_currentLang = in_array($language, $this->_languages, true) ? $language : null;
        }

        return $this->_currentLang;
    }

    /**
     * @return null|string
     */
    public function getLangFromUrl()
    {
        if ($this->_langFromUrl && !Yii::app()->getComponent('request', false) )
            return $this->_langFromUrl;

        /* @var $request \CHttpRequest */
        $request = Yii::app()->getRequest();

        $path = explode('/', $request->getPathInfo());
        $language = !empty($path[0]) ? $path[0] : null;

        if ($language === null) {
            $language = $request->getQuery($this->langParam);
        }

        $language = in_array($language, $this->_languages, true) ? $language : null;

        $this->_langFromUrl = $language;


        return $this->_langFromUrl;
    }

    /**
     * @return null|string
     */
    public function getLangFromCookie()
    {
        if ($this->_langFromCookie && !Yii::app()->getComponent('request', false) )
            return $this->_langFromCookie;

        /* @var $request \CHttpRequest */
        $request = Yii::app()->getRequest();

        if (isset($request->cookies[$this->getCookieKey()])) {
            $language = $request->cookies[$this->getCookieKey()]->value;

            $this->_langFromCookie = in_array($language, $this->_languages, true) ? $language : null;
        }


        return $this->_langFromCookie;
    }

    /**
     * @return string
     */
    public function getCookieKey()
    {
        return $this->langParam.'_'.($this->isBackend() ? 'backend' : 'frontend');
    }


    /**
     * @param string $route
     * @param array $params
     * @param string $ampersand
     * @return mixed|string
     */
    public function createUrl($route, $params = [], $ampersand = '&')
    {
        if (count($this->_languages) > 1) {

            if (!isset($params[$this->langParam])) {
                $params[$this->langParam] = $this->getCurrentLang();
            }

            if ($this->getDefaultLang() === $params[$this->langParam]) {
                unset($params[$this->langParam]);
            } elseif (trim($route, '/') === '') {
                return Yii::app()->getHomeUrl().$params[$this->langParam];
            }
        }

        return str_replace('%2F', '/', parent::createUrl($route, $params, $ampersand));
    }

    /**
     * @param $url
     * @param null
     * @return string
     */
    public function replaceLangInUrl($url, $lang = null)
    {
        $parsed = parse_url($url);

        $result = '';

        if (isset($parsed['scheme'])) {
            $result .= $parsed['scheme'].'://';
        }

        if (isset($parsed['user'])) {
            $result .= $parsed['user'];
            if (isset($parsed['pass'])) {
                $result .= ':'.$parsed['pass'];
            }
            $result .= '@';
        }

        if (isset($parsed['host'])) {
            $result .= $parsed['host'].'/';
        }

        if ('path' === $this->urlFormat && isset($parsed['path'])) {
            $path = trim($parsed['path'], '/');

            $replaced = preg_replace_callback(
                '#^(' . implode('|', $this->_languages) . '){1}(\/.*)?$#',
                function($matches) use ($lang) {
                    return $lang . (isset($matches[2]) ? $matches[2] : '');
                },
                $path
            );

            $replaced = trim($replaced, '/');

            if ($path === $replaced && null !== $lang) {
                $replaced = $lang;
                if ($path !== '') {
                    $replaced .= '/'.$path;
                }
            }

            $result .= $replaced;

            if ($result !== '') {
                if (strpos($url, '/') === 0) {
                    $result = '/'.$result;
                }

                if (substr($url, -1) === '/') {
                    $result .= '/';
                }
            }
        }

        if ('get' === $this->urlFormat) {
            $queryParams = [];

            if (isset($parsed['query'])) {
                parse_str($parsed['query'], $queryParams);
            }

            if (null === $lang && isset($queryParams[$this->langParam])) {
                unset($queryParams[$this->langParam]);
            } else {
                $queryParams[$this->langParam] = $lang;
            }

            $query = urldecode(http_build_query($queryParams));

            if ($query !== '') {
                $result .= '?'.$query;
            }
        }

        if ($result === '') {
            $result .= '/';
        }

        return $result;
    }

    /**
     * @param $url
     * @return string
     */
    public function removeLangFromUrl($url)
    {
        return $this->replaceLangInUrl($url);
    }

    /**
     * @return bool
     */
    public function isBackend()
    {
        $url = trim($this->removeLangFromUrl(Yii::app()->getRequest()->getUrl()), '/');

        return strpos($url, 'backend') === 0;
    }
}
