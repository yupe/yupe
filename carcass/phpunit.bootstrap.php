<?php /** hijarian @ 12.11.13 15:05 */
# This is the bootstrap file designed for PHPUnit.
#
# It will initialize the Yii singleton inside the tests context.
# It's not a best practice, but maybe you'll really need it in some integration tests.
# Contents of this file is a ripoff from `yiit.php` script from Yii framework,
# except that instead of generic `yii.php` script it uses our own
# a lot more advanced bootstrap script.
#
# You use it as follows: `bin/phpunit --bootstrap phpunit.bootstrap.php`

defined('YII_ENABLE_EXCEPTION_HANDLER') or define('YII_ENABLE_EXCEPTION_HANDLER',false);
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER',false);

require_once __DIR__ . '/../common/bootstrap.php';

Yii::import('system.test.CTestCase');
Yii::import('system.test.CDbTestCase');
Yii::import('system.test.CWebTestCase');