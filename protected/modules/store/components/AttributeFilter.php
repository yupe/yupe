<?php

class AttributeFilter extends CComponent
{
    public $dropdownTemplate = 'fd-%s-%s';
    public $checkboxTemplate = 'fc-%s';
    public $numberTemplate = 'fn-%s-%s';

    public $dropdownParseTemplate = '/fd-([\w_\*]+)-([\w_\*]+)/';
    public $checkboxParseTemplate = '/fc-([\w_\*]+)/';
    public $numberParseTemplate = '/fn-([\w_\*]+)-([\w_\*]+)/';

    public function init()
    {

    }

    public function getDropdownOptionName(AttributeOption $option)
    {
        if ($option->parent->type == Attribute::TYPE_DROPDOWN) {
            return sprintf($this->dropdownTemplate, $option->parent->name, $option->id);
        }

        return null;
    }

    public function getIsDropdownOptionChecked(AttributeOption $option)
    {
        return Yii::app()->getRequest()->getParam($this->getDropdownOptionName($option), false);
    }

    public function getCheckboxName(Attribute $attribute)
    {
        if ($attribute->type == Attribute::TYPE_CHECKBOX) {
            return sprintf($this->checkboxTemplate, $attribute->name);
        }

        return null;
    }

    /**
     * @param Attribute $attribute
     * @param $value int - 1 - да, 0 - нет, -1 - неважно
     * @return bool
     */
    public function getIsCheckboxChecked(Attribute $attribute, $value = null)
    {
        return Yii::app()->getRequest()->getParam($this->getCheckboxName($attribute), -1) == $value;
    }

    public function getNumberName(Attribute $attribute, $mode = 'from')
    {
        if ($attribute->type == Attribute::TYPE_NUMBER) {
            return sprintf($this->numberTemplate, $attribute->name, $mode);
        }

        return null;
    }

    public function getNumberValue(Attribute $attribute, $mode = 'from')
    {
        return Yii::app()->getRequest()->getParam($this->getNumberName($attribute, $mode), null);
    }

    /**
     * Формирует список атрибутов для передачи в EEavBehavior->getFilterByEavAttributesCriteria
     * @return array
     */
    public function getAttributesFromQuery()
    {
        $res = [];

        $params = [];
        parse_str(Yii::app()->getRequest()->getQueryString(), $params);


        foreach ($params as $param => $value) {
            if (is_string($param)) {
                $matches = null;
                if (preg_match($this->dropdownParseTemplate, $param, $matches)) {
                    $attribute = $matches[1];
                    $option = $matches[2];
                    if (!isset($res[$attribute])) {
                        $res[$attribute] = [];
                    }
                    $res[$attribute][] = $option;
                } elseif (preg_match($this->checkboxParseTemplate, $param, $matches)) {
                    $attribute = $matches[1];
                    switch ($value) {
                        case 1:
                            $res[$attribute] = [1];
                            break;
                        case 0:
                            $res[$attribute] = [0];
                            break;
                    }
                } elseif (preg_match($this->numberParseTemplate, $param, $matches)) {
                    if ($value === '') {
                        continue;
                    }
                    $attribute = $matches[1];
                    $mode = $matches[2];
                    switch ($mode) {
                        case 'from':
                            $res[] = ['>=', $attribute, (float)$value];
                            break;
                        case 'to':
                            $res[] = ['<=', $attribute, (float)$value];
                            break;
                    }
                }
            }
        }

        return $res;
    }
}
