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
use Yii;
use CException;
use CHttpCookie;

class LanguageBehavior extends CBehavior
{
    public $lang = false;

    private $_lang = false;
    private $_defaultLang = false;
    private $_langFromUrl = false;

    /**
     * @var LangUrlManager
     */
    private $lm;

    /**
     * Подключение события
     * @param CComponent $owner - 'хозяин' события
     * @return void
     */
    public function attach($owner)
    {
        $this->lm = Yii::app()->getUrlManager();
        if (count($this->lm->languages) > 1 && is_array($this->lm->languages)) {
            $owner->attachEventHandler('onBeginRequest', [$this, 'handleLanguageBehavior']);
        }
    }

    /**
     * Язык
     *
     * @return string
     */
    public function getLang()
    {
        if ($this->_lang === false) {
            $lang = $this->getUrlLang() ?: ($this->getCookieLang() ?: $this->lm->getAppLang());
            $this->_lang = in_array($lang, $this->lm->languages) ? $lang : null;
        }

        return $this->_lang;
    }

    /**
     * Язык из url
     * @return bool|null
     * @throws CException
     */
    public function getUrlLang()
    {
        if ($this->_langFromUrl === false) {
            $path = explode('/', Yii::app()->getRequest()->getPathInfo());
            $lang = !empty($path[0]) ? $path[0] : null;
            if ($lang === null) {
                $lang = isset($_GET[$this->lm->langParam]) ? $_GET[$this->lm->langParam] : null;
            }
            $lang = in_array($lang, $this->lm->languages) ? $lang : null;
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
        $r = Yii::app()->getRequest();
        $lang = isset($r->cookies[$this->lm->langParam]) ? $r->cookies[$this->lm->langParam]->value : null;

        return $lang;
    }

    /**
     * Обработка запроса
     *
     * @param mixed $event
     * @return void
     */
    public function handleLanguageBehavior($event)
    {
        $this->setLanguage($this->getLang());

        $this->lang = ($this->lm->getAppLang() === $this->getLang() ? false : $this->getLang());

        // язык передан в url, но он равен дефолтному языку
        if ($this->getUrlLang() !== null && $this->lang === false) {
            Yii::app()->getRequest()->redirect(Yii::app()->homeUrl . $this->lm->getCleanUrl(Yii::app()->getRequest()->url));
        }
    }

    /**
     * Устанавливаем язык приложения
     *
     * @param string $language - требуемый язык
     */
    protected function setLanguage($language)
    {
        // Устанавливаем состояние языка:
        Yii::app()->user->setState($this->lm->langParam, $language);

        Yii::app()->request->cookies[$this->lm->langParam] = new CHttpCookie($this->lm->langParam, $language);

        // И наконец, выставляем язык приложения:
        Yii::app()->language = $language;
    }
}
