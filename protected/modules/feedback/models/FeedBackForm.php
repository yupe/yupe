<?php

/**
 * FeedBackForm бозовая форма обратной связи для публичной части сайта
 *
 * @category YupeController
 * @package  yupe.modules.feedback.models
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/
class FeedBackForm extends CFormModel implements IFeedbackForm
{

    public function getName()
    {
        return 'name';
    }

    public function getEmail()
    {
        return 'email';
    }

    public function getTheme()
    {
        return 'theme';
    }

    public function getText()
    {
        return 'text';
    }

    public function getPhone()
    {
        return 'phone';
    }

    public function getType()
    {
        return '>type';
    }
}
