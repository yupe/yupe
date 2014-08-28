<?php

class EditProfilePage
{
    // include url of current page
    const URL = '/profile';

    public static $emailField = 'ProfileForm[email]';

    public static function getPublicProfileUrl($user)
    {
        return "/users/{$user}";
    }
}
