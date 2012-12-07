<?php
/**
 * CFileHelper класс для работы с файлами.
 *
 * @author Yupe Team
 * @link http://yupe.ru/
 */
 
class YFile extends CFileHelper
{
    public static function getTranslatedName($word)
    {
        return YText::translit($word);
    }

    public static function pathIsWritable($name, $ext, $path)
    {
        if (self::checkPath($path))
            return $path . self::getTranslatedName($name) . '.' . $ext;
        else
            return false;
    }

    public static function checkPath($path)
    {
        if (!is_dir($path)) // проверка на существование директории
            return mkdir($path); // возвращаем результат создания директории
        else if (!is_writable($path)) // проверка директории на доступность записи
            return false;
        return true; // папка существует и доступна для записи
    }
}