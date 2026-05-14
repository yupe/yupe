<?php
/**
 * Выполняем пост-обработку маршрутизации и назначения языка:
 *
 * @category YupeBehavior
 * @package  yupe.modules.yupe.components.urlManager
 * @author   YupeTeam <support@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     https://yupe.ru
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
     * @var LangUrlManager
     */
    private $lm;

    /**
     * @param \CWebApplication $owner
     */
    public function attach($owner)
    {
        $this->lm = $owner->getUrlManager();
        if (count($this->lm->getAvailableLanguages()) > 1) {
            $owner->attachEventHandler('onBeginRequest', [$this, 'handleLanguageBehavior']);
        }
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

        $current = $this->lm->getCurrentLang();
        $this->setLanguage($current);

        $default = $this->lm->getDefaultLang();
        $fromUrl = $this->lm->getLangFromUrl();

        if (null === $fromUrl && $current !== $default) {
            $request->redirect(
                $this->lm->replaceLangInUrl($request->getUrl(), $current)
            );
        }

        if (null !== $fromUrl && $current === $default) {
            $request->redirect(
                $this->lm->removeLangFromUrl($request->getUrl())
            );
        }
    }

    /**
     * @param string $language
     */
    protected function setLanguage($language)
    {
        Yii::app()->getUser()->setState($this->lm->getCookieKey(), $language);
        Yii::app()->getRequest()->cookies[$this->lm->getCookieKey()] = new CHttpCookie($this->lm->getCookieKey(), $language);
        Yii::app()->setLanguage($language);
    }
}
