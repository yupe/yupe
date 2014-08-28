<?php
/**
 * Migrator.php file.
 *
 * This file contains classes which will be mocked.
 * Yii generate CException when we try to strub class extends from CComponent,
 * if $__mosked  property have not been initialized
 *
 * @author Anton Kucherov <idexter.ru@gmail.com>
 * @link http://idexter.ru/
 * @copyright 2013 idexter.ru
 */

namespace mocked;

class Migrator extends \yupe\components\Migrator
{
    public $__mocked;
}
