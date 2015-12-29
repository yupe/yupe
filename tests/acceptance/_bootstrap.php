<?php
// Here you can initialize variables that will for your tests

foreach (glob(__DIR__ . '/_pages/*.php') as $filename) {
    require_once $filename;
}

require_once 'user/steps/UserSteps.php';