<?php
/**
 * YFormModel - базовый класс для всех form-моделей Юпи!
 *
 * Все модели, разработанные для Юпи! должны наследовать этот класс.
 *
 * @package engine.core.components
 * @abstract
 * @author engine team
 * @version 0.0.3
 * @link http://engine.ru - основной сайт
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