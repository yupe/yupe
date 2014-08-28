<?php
namespace yupe\helpers;

class Html
{
    const SUCCESS = 'success';

    const DEF = 'default';

    const PRIMARY = 'primary';

    const INFO = 'info';

    const WARNING = 'warning';

    const DANGER = 'danger';

    protected static function render($class, $text, $strip = true)
    {
        $class = strip_tags($class);

        if ($strip) {
            $text = strip_tags($text);
        }

        return "<span class='label label-{$class}'>{$text}</span>";
    }

    public static function success($text, $strip = true)
    {
        return static::render(self::SUCCESS, $text, $strip);
    }

    public static function def($text, $strip = true)
    {
        return static::render(self::DEF, $text, $strip);
    }

    public static function primary($text, $strip = true)
    {
        return static::render(self::PRIMARY, $text, $strip);
    }

    public static function info($text, $strip = true)
    {
        return static::render(self::INFO, $text, $strip);
    }

    public static function warning($text, $strip = true)
    {
        return static::render(self::WARNING, $text, $strip);
    }

    public static function danger($text, $strip = true)
    {
        return static::render(self::DANGER, $text, $strip);
    }

    public static function label($status, $text, array $map)
    {
        if (!isset($map[$status]) || $map[$status] === self::DEF) {
            return static::def($text);
        }

        return static::$map[$status]($text);
    }
}
