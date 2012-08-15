<?php
class LanguageBehavior extends CBehavior
{

    public function attach($owner)
    {
        $owner->attachEventHandler('onBeginRequest', array($this, 'handleLanguageBehavior'));
    }

    public function handleLanguageBehavior($event)
    {
        $app  = Yii::app();
        $user = $app->user;
        $lm   = Yii::app()->urlManager;
        $l    = null;

        if ( !is_array($lm->languages)) return;

        // Если указан язык известный нам
        if ((
                isset($_GET[$lm->langParam]) && 
                in_array($_GET[$lm->langParam], $lm->languages) && 
                ($l = $_GET[$lm->langParam])
        ) || (
                ($l = substr(Yii::app()->request->getPathInfo(), 0, 2)) &&
                (2 == strlen($l)) &&
                in_array($l, $lm->languages)
        ))
        {

            // Если текущий язык у нас не тот же, что указан - поставим куку и все дела
            if ($app->language != $l)
                $this->setLanguage($l);

            // Если указанный язык в URL в виде пути или параметра - нативный для приложения
            if ( $l == Yii::app()-> sourceLanguage )
            {
                // Если указан в пути, редиректим на "чистый URL"
                $l = substr(Yii::app()->request->getPathInfo(), 0, 2);
                if ( (2 == strlen($l)) && ($l == Yii::app()->sourceLanguage))
                {
                    $this->setLanguage($l);
                    if(!Yii::app()->request->isAjaxRequest)
                        Yii::app()->request->redirect(Yii::app()->homeUrl . $lm->getCleanUrl(substr(Yii::app()->request->getPathInfo(), 2)));
                }
            }
        }
        else {
            $l = null;

            // Пытаемся определить язык из сессии
            if ($user->hasState($lm->langParam))
                $l = $user->getState($lm->langParam);
            // Если в сессии нет - пробуем получить из кук
            else if (isset($app->request->cookies[$lm->langParam]) && in_array($app->request->cookies[$lm->langParam]->value, $lm->languages))
                $l = $app->request->cookies[$lm->langParam]->value;
            // Если и в куках не нашлось языка - получаем код языка из предпочтительной локали, указанной в браузере у клиента
            else if ( $l = Yii::app()->getRequest()->getPreferredLanguage())
                $l = Yii::app()->locale->getLanguageID($l);

            // иначе по-умолчанию
            if(!$l || !in_array($l, $lm->languages))
                $app->language = $app->sourceLanguage;

            // Сделаем редирект на нужный url с указанием языка, если он не нативен
            if ($l != Yii::app()->sourceLanguage)
            {
                $this->setLanguage($l);
                if(!Yii::app()->request->isAjaxRequest)
                    Yii::app()->request->redirect((Yii::app()->homeUrl . "/" . $l) . $lm->getCleanUrl(Yii::app()->request->getPathInfo()));
            } else
                Yii::app()->language = $l;
        }
    }

    protected function setLanguage($language)
    {
        $lp  = Yii::app()->urlManager->langParam;
        Yii::app()->user->setState($lp, $language);
        $cookie = new CHttpCookie($lp, $language);
        $cookie->expire = time() + (60 * 60 * 24 * 365); // (1 year)
        Yii::app()->request->cookies[$lp] = $cookie;
        Yii::app()->language = $language;
    }
}