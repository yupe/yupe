<?php
/**
 * Выполняем пост-обработку маршрутизации и назначения языка:
 *
 * @category YupeBehavior
 * @package  yupe.modules.yupe.components.urlManager
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 */
namespace yupe\components\urlManager;

use CBehavior;
use CHttpCookie;
use Yii;

/**
 * Class LanguageBehavior
 * @package yupe\components\urlManager
 */
class LanguageBehavior extends CBehavior
{
    /**
     * @var string
     */
    private $_lang;
    /**
     * @var string
     */
    private $_langFromUrl;
    /**
     * @var LangUrlManager
     */
    private $lm;

    /**
     * @param \CWebApplication $owner
     */
    public function attach($owner)
    {
        $this->lm = $owner->getUrlManager();
        if (is_array($this->lm->languages) && count($this->lm->languages) > 1) {
            $owner->attachEventHandler('onBeginRequest', [$this, 'handleLanguageBehavior']);
        }
    }

    /**
     * @return null|string
     */
    public function getLang()
    {
        if (null === $this->_lang) {
            $lang = $this->getUrlLang();
            if (null === $lang) {
                $lang = $this->getCookieLang() ?: $this->lm->getAppLang();
            }
            $this->_lang = in_array($lang, $this->lm->languages, true) ? $lang : null;
        }

        return $this->_lang;
    }

    /**
     * @return null|string
     */
    public function getUrlLang()
    {
        if (null === $this->_langFromUrl) {

            /* @var $request \CHttpRequest */
            $request = Yii::app()->getRequest();

            $path = explode('/', $request->getPathInfo());
            $lang = !empty($path[0]) ? $path[0] : null;

            if ($lang === null) {
                $lang = $request->getQuery($this->lm->langParam);
            }

            $lang = in_array($lang, $this->lm->languages, true) ? $lang : null;
            $this->_langFromUrl = $lang;
        }

        return $this->_langFromUrl;
    }

    /**
     * Получаем язык из кукисов
     *
     * @return string
     */
    public function getCookieLang()
    {
        /* @var $request \CHttpRequest */
        $request = Yii::app()->getRequest();

        if (isset($request->cookies[$this->lm->langParam])) {
            $lang = $request->cookies[$this->lm->langParam]->value;

            return in_array($lang, $this->lm->languages, true) ? $lang : null;
        }

        return null;
    }

    /**
     * Обработка запроса
     *
     * @param mixed $event
     * @return void
     */
    public function handleLanguageBehavior($event)
    {
        /* @var $request \CHttpRequest */
        $request = Yii::app()->getRequest();
        $current = $this->getLang();
        $default = $this->lm->getAppLang();
        $fromUrl = $this->getUrlLang();

        $this->setLanguage($current);

        if (null === $fromUrl && $current !== $default) {
            $request->redirect(
                Yii::app()->getHomeUrl() . $this->lm->replaceLangUrl($request->getUrl(), $current)
            );
        }

        if (null !== $fromUrl && $current === $default) {
            $request->redirect(
                Yii::app()->getHomeUrl() . $this->lm->getCleanUrl($request->getUrl())
            );
        }
    }

    /**
     * @param string $language
     */
    protected function setLanguage($language)
    {
        Yii::app()->getUser()->setState($this->lm->langParam, $language);
        Yii::app()->getRequest()->cookies[$this->lm->langParam] = new CHttpCookie($this->lm->langParam, $language);
        Yii::app()->setLanguage($language);
    }
}
