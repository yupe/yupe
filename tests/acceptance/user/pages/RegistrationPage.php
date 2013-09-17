<?php

class RegistrationPage
{
    // include url of current page
    const URL = '/registration';

    public static $buttonLabel = 'Зарегистрироваться';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: EditPage::route('/123-post');
     */
     public static function route($param)
     {
        return static::URL.$param;
     }
}