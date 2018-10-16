<?php
namespace tests\acceptance\pages;

class RecoveryPage
{
    public static $URL = '/recovery';

    public static $emailField = 'RecoveryForm[email]';

    public static $buttonLabel = 'Восстановить пароль';

    public static function getConfirmRoute($code)
    {
        return "/confirm/{$code}";
    }

    public static function getRecoveryRoute($code)
    {
        return "/recovery/{$code}";
    }
}
