<?php
namespace tests\acceptance\pages;

class LoginPage
{
    public static $URL = '/login';

    public static $passwordField = 'LoginForm[password]';

    public static $emailField = 'LoginForm[email]';

    public static $rememberMeField = 'LoginForm[remember_me]';

    public static $userEmail = 'yupe@yupe.local';

    public static $userPassword = 'testpassword';
}
