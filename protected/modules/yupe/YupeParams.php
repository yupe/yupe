<?php

/**
 * YupeParams файл класса.
 *
 * @author Andrey Opeykin <aopeykin@gmail.com>
 * @link http://yupe.ru
 * @copyright Copyright &copy; 2012 Yupe!
 * @license BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 */
/**
 * Модуль yupe - модуль отдельных параметров.
 *
 */
class YupeParams extends YWebModule
{
    public $availableLanguages = "ru,en";
    public $defaultLanguage = "ru";
    public $defaultBackendLanguage = "ru";

    public function init()
    {

    }

    public function runParentInit()
    {
        parent::init();
    }
}
