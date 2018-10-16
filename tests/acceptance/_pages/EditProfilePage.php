<?php
namespace tests\acceptance\pages;

class EditProfilePage
{
    // include url of current page
    const URL = '/profile';

    public static $emailField = 'User[email]';

    public static function getPublicProfileUrl($user)
    {
        return "/users/{$user}";
    }
}
