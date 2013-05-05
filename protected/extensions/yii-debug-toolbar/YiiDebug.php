<?php
/**
 * YiiDebug class file.
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 */


/**
 * YiiDebug class.
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 * @version $Id$
 * @package YiiDebugToolbar
 * @since 1.1.7
 */

class YiiDebug extends CComponent
{

    /**
     * Displays a variable.
     * This method achieves the similar functionality as var_dump and print_r
     * but is more robust when handling complex objects such as Yii controllers.
     * @param mixed $var variable to be dumped
     */
    public static function dump($var, $depth=10)
    {
        is_string($var) && $var = trim($var);
        echo str_replace('&nbsp;', ' ', CVarDumper::dumpAsString($var, $depth, true));
    }

    /**
     * Writes a trace dump.
     * @param string $msg message to be logged
     */
    public static function trace($message)
    {
        Yii::trace(self::dump($message), 'dump');
    }

    public static function getClass($class)
    {
        return new ReflectionClass($class);
    }

    public static function getClassMethod($class,$name)
    {
        $class = self::getClass($class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    public static function t($str,$params=array(),$dic='yii-debug-toolbar') {
        return Yii::t("YiiDebug.".$dic, $str, $params);
    }
}
