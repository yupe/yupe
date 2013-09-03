<?php
/**
 * Файл основных настроек приложения для production сервера:
 *
 * @category YupeConfig
 * @package  Yupe
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3 (dev)
 * @link     http://yupe.ru
 *
 **/

namespace application\config;

use CMap;
use application\components\ConfigManager;

$base        = require_once dirname(__FILE__) . '/base.php';
$userspace   = require_once dirname(__FILE__) . '/userspace.php';

return (new ConfigManager)->init($base, $userspace);
