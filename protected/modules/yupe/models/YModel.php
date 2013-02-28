<?php
/**
 * YModel - базовый класс для всех моделей Юпи!
 *
 * Все модели, разработанные для Юпи! должны наследовать этот класс.
 *
 * @package yupe.core.components
 * @abstract
 * @author yupe team
 * @version 0.0.3
 * @link http://yupe.ru - основной сайт
 * 
 */
 
abstract class YModel extends Model
{
    public function attributeDescriptions()
    {
        return array();
    }

    public function getAttributeDescription($attribute)
    {
        $descriptions = $this->attributeDescriptions();
        return (isset($descriptions[$attribute])) ? $descriptions[$attribute] : '';
    }
}