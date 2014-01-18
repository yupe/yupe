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
use Exception;
use CException;
use yupe\widgets\YFlashMessages;
use CHttpCookie;

class LanguageBehavior extends CBehavior
{
    public $lang          = false;

    private $_lang        = false;
    private $_defaultLang = false;
    private $_appLang     = false;

    /**
     * Подключение события:
     *
     * @param Component $owner - 'хозяин' события
     *
     * @return void
     */
    public function attach($owner)
    {
        if (count(Yii::app()->urlManager->languages) > 1 && is_array(Yii::app()->urlManager->languages)) {
            $owner->attachEventHandler('onBeginRequest', array($this, 'handleLanguageBehavior'));
        }
    }

    /**
     * Получаем язык из кукисов:
     *
     * @return string
     */
    public function getCookieLang()
    {
        $lm = Yii::app()->urlManager;
        
        // А вдруг запрещена запись в runtime-каталог:
        try {
            $lang = Yii::app()->getModule('yupe')->cache
                    && isset(Yii::app()->getRequest()->cookies[$lm->langParam])
                    && in_array(Yii::app()->getRequest()->cookies[$lm->langParam]->value, $lm->languages)
                ? Yii::app()->getRequest()->cookies[$lm->langParam]->value
                : (
                    $lm->preferredLanguage && Yii::app()->getRequest()->getPreferredLanguage()
                    ? Yii::app()->locale->getLanguageID($this->lang)
                    : false
                );
        } catch (Exception $e) {
            $lang = Yii::app()->sourceLanguage;
        }

        return $lang;
    }

    /**
     * Получаем язык по умолчанию
     * берём его либо из кукисов, либо определяя язык
     * браузера
     *
     * @return string
     */
    public function getDefaultLang()
    {
        $lm = Yii::app()->urlManager;

        if ($this->_defaultLang === false) {
            try {
                // Пробуем получить код языка из кук
                $this->_defaultLang = $this->getCookieLang();

                $this->_defaultLang = $this->_defaultLang
                                    ?: $lm->getAppLang();

            } catch (CException $e) {
                $this->_defaultLang = $lm->getAppLang();

                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    $e->getMessage()
                );
            }
        }

        return $this->_defaultLang;
    }

    /**
     * Получаем язык:
     *
     * @return string
     */
    public function getLang()
    {
        $lm = Yii::app()->urlManager;

        if ($this->_lang === false) {
            $this->_lang = isset($_GET[$lm->langParam])
                        ? $_GET[$lm->langParam]
                        : $this->getDefaultLang();
        }

        $reqLang = substr(Yii::app()->getRequest()->getPathInfo(), 0, 2);
        //$reqLang = current(explode('/', Yii::app()->getRequest()->getPathInfo()));
        

        return in_array($reqLang, $lm->languages)
            ? $reqLang
            : $this->_lang;
    }

    /**
     * Обработка запросов, предназначена для корректной
     * обработки запросов определения текущего языка:
     *
     * @param mixed $event - парметры события
     *
     * @return void
     */
    public function handleLanguageBehavior($event)
    {
        // Получаем инстанс urlManager'а
        $lm = Yii::app()->urlManager;

        // Получаем homeUrl с добавлением "/"
        // если он не указа в конце Yii::app()->homeUrl
        $home = Yii::app()->homeUrl
                . (Yii::app()->homeUrl[strlen(Yii::app()->homeUrl) - 1] != "/"
                    ? '/'
                    : ''
                );
        
        // Получаем текущий url:
        $path = Yii::app()->getRequest()->getPathInfo();

        // Проверяем переданный язык:
        
        $langIsset = (
            isset($_GET[$lm->langParam]) || $path == $this->getLang() || substr($path, 2, 1) == '/'
        );

        $this->setLanguage(
            $this->getDefaultLang()
        );

        $this->setLanguage(
            $this->getLang()
        );

        // Если не передан язык не нативный:
        
        
        if ($langIsset === false && $lm->getAppLang() !== $this->getLang()) {
            Yii::app()->getRequest()->redirect(
                $home . $lm->replaceLangUrl(
                    $lm->getCleanUrl(Yii::app()->getRequest()->url), $this->getLang()
                )
            );
        }

        // Если переданый язык - является source-языком
        $this->lang = $lm->getAppLang() === $this->getLang()
                    ? false
                    : $this->getLang();

        if ($this->lang === false && $langIsset !== false) {
            // Редирект на URL без указания языка
            Yii::app()->getRequest()->redirect(
                $home . $lm->getCleanUrl(Yii::app()->getRequest()->url)
            );
        } elseif ($langIsset === true && $this->lang !== current(explode('/',$path))) {
            Yii::app()->getRequest()->redirect(
                $home . $lm->replaceLangUrl(
                    $lm->getCleanUrl(Yii::app()->getRequest()->url), $this->lang
                )
            );
        }
    }

    /**
     * Устанавливаем язык приложения:
     *
     * @param string $language - требуемый язык
     *
     * @return void
     */
    protected function setLanguage($language)
    {
        // Устанавливаем состояние языка:
        Yii::app()->user->setState(Yii::app()->urlManager->langParam, $language);
        
        try {
            if (Yii::app()->getModule('yupe')->cache) {
                Yii::app()->getRequest()->cookies->add(
                    Yii::app()->urlManager->langParam, new CHttpCookie(
                        Yii::app()->urlManager->langParam,
                        $language, array(
                            'expire' => time() + (60 * 60 * 24 * 365)
                        )
                    )
                );
            }
        } catch (CException $e) {
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                $e->getMessage()
            );
        }

        // И наконец, выставляем язык приложения:
        Yii::app()->language = $language;
    }
}
