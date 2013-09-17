<?php
// Here you can initialize variables that will for your tests
require_once 'user/pages/LoginPage.php';
require_once 'user/pages/RecoveryPage.php';
require_once 'user/pages/LogoutPage.php';
require_once 'user/pages/EditProfilePage.php';
require_once 'user/pages/RegistrationPage.php';

\Codeception\Util\Autoload::registerSuffix('Steps', __DIR__.DIRECTORY_SEPARATOR.'_steps');
\Codeception\Util\Autoload::registerSuffix('Page', __DIR__.DIRECTORY_SEPARATOR.'_pages');