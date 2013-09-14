<?php
// Here you can initialize variables that will for your tests
require_once 'user/pages/LoginPage.php';
require_once 'user/pages/RecoveryPage.php';
require_once 'user/pages/LogoutPage.php';

\Codeception\Util\Autoload::registerSuffix('Steps', __DIR__.DIRECTORY_SEPARATOR.'_steps');