<?php
/**
 * yupe\models\YFormModel - базовый класс для всех form-моделей Юпи!
 *
 * Все модели, разработанные для Юпи! должны наследовать этот класс.
 *
 * @package  yupe.modules.yupe.models
 * @abstract
 * @author yupe team
 * @version 0.0.3
 * @link http://yupe.ru - основной сайт
 *
 */

namespace yupe\models;

use CFormModel;

/**
 * Class YFormModel
 * @package yupe\models
 */
abstract class YFormModel extends CFormModel
{
    /**
     * @return array
     */
    public function attributeDescriptions()
    {
        return [];
    }

    /**
     * @param $attribute
     * @return string
     */
    public function getAttributeDescription($attribute)
    {
        $descriptions = $this->attributeDescriptions();

        return (isset($descriptions[$attribute])) ? $descriptions[$attribute] : '';
    }
}
