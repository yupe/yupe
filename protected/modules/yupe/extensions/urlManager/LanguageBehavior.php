<?php
class LanguageBehavior extends CBehavior
{
    public function attach($owner)
    {
        if (count(Yii::app()->urlManager->languages) > 1)
            $owner->attachEventHandler('onBeginRequest', array($this, 'handleLanguageBehavior'));
    }

    /**
     *  Обработка запросов, предназначена для корректной обработки запросов определения текущего языка
     */
    public function handleLanguageBehavior($event)
    {
        $lm = Yii::app()->urlManager;
        if (!is_array($lm->languages) || count($lm->languages) <= 1)
            return;

        $app  = Yii::app();
        $home = $app->homeUrl . ($app->homeUrl[strlen($app->homeUrl) - 1] != "/" ? '/' : '');
        $path = $app->request->getPathInfo();
        $l = false;

        // Если указан язык известный нам
        if ((
            // Если метод соответствует urlManager->languageInPath или было обращение через GET парамметр
            isset($_GET[$lm->langParam])                    &&
            in_array($_GET[$lm->langParam], $lm->languages) &&
            $l = $_GET[$lm->langParam]
        ) || (
            // Используется метод передачи в виде GET-переменной, но заход выполнен с указанием языка в пути
            $l = substr($path, 0, 2)     &&
            strlen($l) == 2              &&
            in_array($l, $lm->languages) &&
            isset($path[3])              &&
            $path[3] == '/'
        ))
        {
            // Если текущий язык у нас не тот же, что указан - поставим куку и все дела
            if ($app->language != $l || $l == $app->sourceLanguage)
                $this->setLanguage($l);

            if (//язык в URL в виде пути или параметра - нативный для приложения
                $l == $app->sourceLanguage    ||
                // Язык установлен на вывод в GET-парамметре, но обращение было через путь
                !isset($_GET[$lm->langParam]) ||
                // Язык установлен на вывод в пути, но обращение было через GET-парамметр
                ($lm->languageInPath && substr($path, 0, 2) != $l)
            )
            {
                // Редирект на URL без указания языка
                if (!$app->request->isAjaxRequest)
                    $app->request->redirect($home . $lm->getCleanUrl($app->request->url));
            }
        }
        else if ($app->hasModule('user'))
        {
            $user = $app->user;

            // Пытаемся определить код языка из сессии
            if ($user->hasState($lm->langParam))
                $l = $user->getState($lm->langParam);
            // Пробуем получить код языка из кук
            else if ($app->getModule('yupe')->cache && isset($app->request->cookies[$lm->langParam]) && in_array($app->request->cookies[$lm->langParam]->value, $lm->languages))
                $l = $app->request->cookies[$lm->langParam]->value;
            // Получаем код языка из предпочтительной локали, указанной в браузере клиента
            else if ($lm->preferredLanguage && $l = $app->request->getPreferredLanguage())
                $l = $app->locale->getLanguageID($l);
            else
                $l = false;

            // Если язык не получен, и не найден в списке возможных
            if (!$l || !in_array($l, $lm->languages))
                $l = $app->language = $app->sourceLanguage;

            // Сделаем редирект на нужный url с указанием языка, если он не нативен
            if ($l != $app->sourceLanguage)
            {
                $this->setLanguage($l);

                if (!$app->request->isAjaxRequest)
                    $app->request->redirect($home . $lm->replaceLangUrl($lm->getCleanUrl($app->request->url), $l));
            }
            else
                $app->language = $l;
        }
    }

    protected function setLanguage($language)
    {
        $app = Yii::app();
        $lp  = $app->urlManager->langParam;

        $app->user->setState($lp, $language);
        // @TODO если не доступна папка runtime в установщие не создавать куку
        if ($app->getModule('yupe')->cache)
            $app->request->cookies[$lp] = new CHttpCookie($lp, $language, array('expire' => time() + (60 * 60 * 24 * 365)));
        $app->language = $language;
    }
}