<?php
namespace tests\acceptance\pages;

class RegistrationPage
{
    // include url of current page
    const URL = '/registration';

    public static $buttonLabel = 'Регистрация';

    public static $nickNameField = 'RegistrationForm[nick_name]';

    public static $emailField = 'RegistrationForm[email]';

    public static $passwordField = 'RegistrationForm[password]';

    public static $cpasswordField = 'RegistrationForm[cPassword]';

    public static function getActivateRoute($key)
    {
        return "/activate/{$key}";
    }
}
