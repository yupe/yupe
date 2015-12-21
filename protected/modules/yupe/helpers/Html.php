<?php
namespace yupe\helpers;

/**
 * Class Html
 * @package yupe\helpers
 */
class Html
{
    /**
     *
     */
    const SUCCESS = 'success';

    /**
     *
     */
    const DEF = 'default';

    /**
     *
     */
    const PRIMARY = 'primary';

    /**
     *
     */
    const INFO = 'info';

    /**
     *
     */
    const WARNING = 'warning';

    /**
     *
     */
    const DANGER = 'danger';

    /**
     * @param $class
     * @param $text
     * @param bool|true $strip
     * @return string
     */
    protected static function render($class, $text, $strip = true)
    {
        $class = strip_tags($class);

        if ($strip) {
            $text = strip_tags($text);
        }

        return "<span class='label label-{$class}'>{$text}</span>";
    }

    /**
     * @param $text
     * @param bool|true $strip
     * @return string
     */
    public static function success($text, $strip = true)
    {
        return static::render(self::SUCCESS, $text, $strip);
    }

    /**
     * @param $text
     * @param bool|true $strip
     * @return string
     */
    public static function def($text, $strip = true)
    {
        return static::render(self::DEF, $text, $strip);
    }

    /**
     * @param $text
     * @param bool|true $strip
     * @return string
     */
    public static function primary($text, $strip = true)
    {
        return static::render(self::PRIMARY, $text, $strip);
    }

    /**
     * @param $text
     * @param bool|true $strip
     * @return string
     */
    public static function info($text, $strip = true)
    {
        return static::render(self::INFO, $text, $strip);
    }

    /**
     * @param $text
     * @param bool|true $strip
     * @return string
     */
    public static function warning($text, $strip = true)
    {
        return static::render(self::WARNING, $text, $strip);
    }

    /**
     * @param $text
     * @param bool|true $strip
     * @return string
     */
    public static function danger($text, $strip = true)
    {
        return static::render(self::DANGER, $text, $strip);
    }

    /**
     * @param $status
     * @param $text
     * @param array $map
     * @return string
     */
    public static function label($status, $text, array $map)
    {
        if (!isset($map[$status]) || $map[$status] === self::DEF) {
            return static::def($text);
        }

        return static::$map[$status]($text);
    }
}
