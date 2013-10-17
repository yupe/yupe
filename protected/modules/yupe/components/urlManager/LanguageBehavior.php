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
class LanguageBehavior extends CBehavior
{
    public $lang = false;

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

        // Получаем язык из GET-массива или из $path
        $this->lang = isset($_GET[$lm->langParam])
            ? $_GET[$lm->langParam]
            : substr($path, 0, 2);

        // Проверяем переданный язык:
        $langIsset = (
            isset($_GET[$lm->langParam]) || $path == $this->lang || substr($path, 2, 1) == '/'
        );



        // Проверяем нативность языка и указан ли он в параметрах/пути:
        // 1) Если использован нативный для приложения язык
        // 2) Язык установлен на вывод в GET-парамметре,
        //    но обращение было через путь
        // 3) Язык установлен на вывод в пути, но обращение
        //    было через GET-парамметр
        $langNative = $this->lang == Yii::app()->sourceLanguage
            && (!isset($_GET[$lm->langParam]) || ($lm->languageInPath && substr($path, 0, 2) != $this->lang));

        // Если указан язык, который известен нам:
        if (in_array($this->lang, $lm->languages) && $langIsset) {
            // Если текущий язык у нас не тот же, что указан - поставим куку и все дела
            if (Yii::app()->language != $this->lang || $this->lang == Yii::app()->sourceLanguage) {
                $this->setLanguage($this->lang);
            }

            // 1) Если использован нативный для приложения язык
            // 2) Язык установлен на вывод в GET-парамметре,
            //    но обращение было через путь
            // 3) Язык установлен на вывод в пути, но обращение
            //    было через GET-парамметр
            if ($langNative && !Yii::app()->getRequest()->getIsAjaxRequest()) {
                // Редирект на URL без указания языка
                Yii::app()->getRequest()->redirect($home . $lm->getCleanUrl(Yii::app()->getRequest()->url));
            }
        } else {

            try {
                // Пробуем получить код языка из кук
                $cookiesLang = Yii::app()->getModule('yupe')->cache
                            && isset(Yii::app()->getRequest()->cookies[$lm->langParam])
                            && in_array(Yii::app()->getRequest()->cookies[$lm->langParam]->value, $lm->languages)
                        ? Yii::app()->getRequest()->cookies[$lm->langParam]->value
                        : (
                            $lm->preferredLanguage && Yii::app()->getRequest()->getPreferredLanguage()
                            ? Yii::app()->locale->getLanguageID($this->lang)
                            : false
                        );
            } catch (CException $e) {
                $cookiesLang = Yii::app()->sourceLanguage;

                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    $e->getMessage()
                );
            }
            
            $oldLang = $this->lang;

            // Устанавливаем из сессии или заданный в кукисах:
            $this->lang = Yii::app()->user->getState(
                $lm->langParam, $cookiesLang
            );

            // Если язык не получен, и не найден в списке возможных
            if (!$this->lang || !in_array($this->lang, $lm->languages)) {
                $this->lang = Yii::app()->language = Yii::app()->sourceLanguage;
            }

            if ($oldLang != $this->lang
                && !empty($oldLang)
                && ($path == $this->lang || substr($path, 2, 1) == '/')
            ) {
                Yii::app()->urlManager->languages[] = $oldLang;
                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t(
                        'YupeModule.yupe', 'Language "{lang}" is not found!', array(
                            '{lang}' => $oldLang
                        )
                    )
                );
                $undefinedLang = $oldLang;
            }

            // Сделаем редирект на нужный url с указанием языка, если он не нативен
            if ($this->lang != Yii::app()->sourceLanguage || isset($undefinedLang)) {
                $this->setLanguage($this->lang);
                if (!Yii::app()->getRequest()->getIsAjaxRequest())
                    Yii::app()->getRequest()->redirect(
                        $home . $lm->replaceLangUrl(
                            $lm->getCleanUrl(Yii::app()->getRequest()->url), $this->lang
                        )
                    );
            } else {
                // Иначе просто установим язык:
                Yii::app()->language = $this->lang;
            }
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