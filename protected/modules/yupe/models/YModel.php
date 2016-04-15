<?php
/**
 * Класс базовой модели, в которой определены необходимые методы
 * для работы.
 * Все модели, разработанные для Юпи! должны наследовать этот класс.
 *
 * @category YupeComponents
 * @package  yupe.modules.yupe.models
 * @abstract
 * @author   YupeTeam <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @version  0.0.4
 * @link     http://yupe.ru - основной сайт
 *
 **/

namespace yupe\models;

use CActiveRecord;
use Yii;

abstract class YModel extends CActiveRecord
{
    /**
     * Получение ссылки на объект модели
     * Это позволяет не писать каждый раз publiс static model в моделях Yii.
     *
     * @author Zalatov A.
     *
     * @param string $className Если необходимо, можно вручную указать имя класса
     * @return $this
     */
    public static function model($className = null)
    {
        if ($className === null) {
            $className = get_called_class();
        }
        return parent::model($className);
    }

    /**
     * Получение имени класса
     *
     * Этот метод необходим, чтобы постараться избежать использования имени класса как строки.
     * Метод get_class() принимает объект, поэтому не годится для статичного вызова.
     * Например, в relations можно теперь вместо 'CatalogItem' указывать CatalogItem::_CLASS_().
     * Это позволит использовать более точно Find Usages в IDE.
     *
     * Начиная с версии PHP > 5.5 есть магическая константа CLASS, которая аналогична.
     * Но в целях совместимости с более старыми версиями PHP, рекомендуется использовать именно этот метод.
     *
     * @author Zalatov A.
     *
     * @return string
     */
    public static function _CLASS_()
    {
        return get_called_class();
    }


    /**
     * Метод хранящий описания атрибутов:
     *
     * @return array описания атрибутов
     **/
    public function attributeDescriptions()
    {
        return [];
    }

    /**
     * Метод получения описания атрибутов
     *
     * @param string $attribute - id-атрибута
     *
     * @return string описания атрибутов
     **/
    public function getAttributeDescription($attribute)
    {
        $descriptions = $this->attributeDescriptions();

        return (isset($descriptions[$attribute])) ? $descriptions[$attribute] : '';
    }
}
