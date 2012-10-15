<?php
/**
 * YFormModel - базовый класс для всех form-моделей Юпи!
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
 
abstract class YFormModel extends FormModel
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