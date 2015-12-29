<?php
namespace tests\acceptance\pages;

class FeedBackPage
{
    // include url of current page
    const CONTACTS_URL = '/contacts';

    const FAQ_URL = '/faq';

    public static $nameField = 'FeedBackForm[name]';

    public static $emailField = 'FeedBackForm[email]';

    public static $themeField = 'FeedBackForm[theme]';

    public static $textField = 'FeedBackForm[text]';

    public static $buttonLabel = 'Отправить сообщение';

    public static function routeFaq($param)
    {
        return static::FAQ_URL . '/' . $param;
    }
}
