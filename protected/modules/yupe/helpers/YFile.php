<?php

/**
 * yupe\helpers\YFile:: хелпер, содержащий вспомогательные функции для работы с файловой системой
 *
 * @package  yupe.modules.yupe.helpers
 * @subpackage helpers
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @author  Opeykin A. <aopeykin@yandex.ru>
 * @link http://yupe.ru
 *
 */


namespace yupe\helpers;
use yupe\helpers\YText;
use CFileHelper;
use Yii;

class YFile extends CFileHelper
{
    public static function getTranslatedName($word)
    {
        return YText::translit($word);
    }

    public static function pathIsWritable($name, $ext, $path)
    {
        if (self::checkPath($path)) {
            return $path . self::getTranslatedName($name) . '.' . $ext;
        }
        else {
            return false;
        }
    }

    public static function checkPath($path)
    {
        if (!is_dir($path)) { // проверка на существование директории
            return mkdir($path); // возвращаем результат создания директории
        }
        else if (!is_writable($path)) { // проверка директории на доступность записи
            return false;
        }
        return true; // папка существует и доступна для записи
    }


    /**
     * Рекрусивное удаление директорий.
     *
     * @param $path Если $path оканчивается на *, то удаляется только содержимое директории.
     * @since 0.5
     * @return bool
     */
    public static function rmDir($path)
    {
        static $doNotRemoveBaseDirectory = false, $baseDirectory;

        $path = trim($path);
        if (substr($path, -1) == '*') {
            $doNotRemoveBaseDirectory = true;
            $path = substr($path, 0, -1);
        }
        if (substr($path, -1) == '/') {
            $path = substr($path, 0, -1);
        }
        if ($doNotRemoveBaseDirectory) {
            $baseDirectory = $path;
        }

        if (is_dir($path)) {
            $dirHandle = opendir($path);
            while (false !== ($file = readdir($dirHandle))) {
                if ($file != '.' && $file != '..') {
                    $tmpPath = $path . '/' . $file;

                    if (is_dir($tmpPath)) {
                        self::rmDir($tmpPath);
                    } else {
                        if (file_exists($tmpPath)) {
                            unlink($tmpPath);
                        }
                    }
                }
            }
            closedir($dirHandle);

            // удаляем текущую папку
            if ($doNotRemoveBaseDirectory === true && $baseDirectory == $path) {
                return true;
            }
            return rmdir($path);
        } elseif (is_file($path) || is_link($path)) {
            return unlink($path);
        } else {
            return false;
        }
    }
}