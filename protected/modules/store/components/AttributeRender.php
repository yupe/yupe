<?php

/**
 * Class AttributeRender
 */
class AttributeRender
{
    /**
     * @param $attribute
     * @param null $value
     * @param null $name
     * @param array $htmlOptions
     * @return mixed|null|string
     */
    public static function renderField($attribute, $value = null, $name = null, $htmlOptions = [])
    {
        $name = $name ?: 'Attribute['.$attribute->id.']';
        switch ($attribute->type) {
            case Attribute::TYPE_SHORT_TEXT:
                return CHtml::textField($name, $value, $htmlOptions);
                break;
            case Attribute::TYPE_TEXT:
                return Yii::app()->getController()->widget(
                    Yii::app()->getModule('store')->getVisualEditor(),
                    [
                        'name' => $name,
                        'value' => $value,
                    ],
                    true
                );
                break;
            case Attribute::TYPE_DROPDOWN:
                $data = CHtml::listData($attribute->options, 'id', 'value');

                return CHtml::dropDownList($name, $value, $data, array_merge($htmlOptions, (['empty' => '---'])));
                break;
            case Attribute::TYPE_CHECKBOX_LIST:
                $data = CHtml::listData($attribute->options, 'id', 'value');

                return CHtml::checkBoxList($name.'[]', $value, $data, $htmlOptions);
                break;
            case Attribute::TYPE_CHECKBOX:
                return CHtml::checkBox($name, $value, CMap::mergeArray(['uncheckValue' => 0], $htmlOptions));
                break;
            case Attribute::TYPE_NUMBER:
                return CHtml::numberField($name, $value, $htmlOptions);
                break;
            case Attribute::TYPE_IMAGE:
                return CHtml::fileField($name, null, $htmlOptions);
                break;
        }

        return null;
    }

    /**
     * @param $attribute
     * @param $value
     * @return string
     */
    public static function renderValue($attribute, $value)
    {
        $unit = $attribute->unit ? ' '.$attribute->unit : '';
        $res = '';
        switch ($attribute->type) {
            case Attribute::TYPE_TEXT:
            case Attribute::TYPE_SHORT_TEXT:
            case Attribute::TYPE_NUMBER:
                $res = $value;
                break;
            case Attribute::TYPE_DROPDOWN:
                $data = CHtml::listData($attribute->options, 'id', 'value');
                if (!is_array($value) && isset($data[$value])) {
                    $res = $data[$value];
                }
                break;
            case Attribute::TYPE_CHECKBOX:
                $res = $value ? Yii::t("StoreModule.store", "Yes") : Yii::t("StoreModule.store", "No");
                break;
        }

        return $res.$unit;
    }
}