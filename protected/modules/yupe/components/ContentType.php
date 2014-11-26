<?php
/**
 * ContentType of file
 * Класс определяющий тип контента:
 *
 * @category YupeComponents
 * @package  yupe.modules.yupe.components
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.0.1
 * @link     http://yupe.ru
 **/

namespace yupe\components;

class ContentType
{
    /**
     * Константы типов:
     **/
    const TYPE_HTML = 1;
    const TYPE_TEXT = 2;
    const TYPE_JSON = 3;
    const TYPE_JS = 4;
    const TYPE_XML = 5;
    const TYPE_RSS = 6;
    const TYPE_ATOM = 7;
    const TYPE_ARCH_ZIP = 8;
    const TYPE_ARCH_RAR = 9;
    const TYPE_ARCH_TAR = 10;
    const TYPE_ARCH_GZIP = 11;

    /**
     * Фукция устанавливающая тип контента
     *
     * @param integer $contentTypeId - id типа контента
     *
     * @return nothing
     **/
    public static function setHeader($contentTypeId)
    {
        if (!is_null(self::getHeader($contentTypeId))) {
            header(self::getHeader($contentTypeId));

            return true;
        } else {
            return false;
        }
    }

    /**
     * Фукция возвращающая строку типа контента
     *
     * @param integer $contentTypeId - id типа контента
     *
     * @return string строка типа контента
     **/
    public static function getHeader($contentTypeId)
    {
        $contentTypes = self::getTypes();
        if (isset($contentTypes[$contentTypeId])) {
            return $contentTypes[$contentTypeId];
        } else {
            return null;
        }
    }

    /**
     * Функция возвращающая все типы контента:
     *
     * @return mixed все типы контента
     **/
    public static function getTypes()
    {
        return [
            self::TYPE_HTML      => 'Content-type: text/html',
            self::TYPE_TEXT      => 'Content-type: text/plain',
            self::TYPE_JSON      => 'Content-type: application/json',
            self::TYPE_JS        => 'Content-type: application/javascript',
            self::TYPE_XML       => 'Content-type: application/xml',
            self::TYPE_RSS       => 'Content-type: application/rss+xml',
            self::TYPE_ATOM      => 'Content-type: application/atom+xml',
            self::TYPE_ARCH_ZIP  => 'Content-type: application/zip',
            self::TYPE_ARCH_RAR  => 'Content-type: application/x-rar',
            self::TYPE_ARCH_TAR  => 'Content-type: application/x-tar',
            self::TYPE_ARCH_GZIP => 'Content-type: application/gzip',
        ];
    }
}
