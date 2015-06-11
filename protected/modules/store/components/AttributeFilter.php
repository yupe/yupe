<?php

/**
 * Class AttributeFilter
 */
class AttributeFilter extends CComponent
{
    /**
     *
     */
    const MAIN_SEARCH_PARAM_PRODUCER = 'brand';
    /**
     *
     */
    const MAIN_SEARCH_PARAM_CATEGORY = 'category';

    const MAIN_SEARCH_PARAM_NAME = 'name';

    /**
     * @var string
     */
    public $dropdownTemplate = '%s[]';
    /**
     * @var string
     */
    public $checkboxTemplate = '%s';
    /**
     * @var string
     */
    public $numberTemplate = '%s[%s]';

    /**
     * @var string
     */
    public $stringTemplate = '%s';

    /**
     *
     */
    public function init()
    {

    }

    /**
     * @param $paramName
     * @param $value
     * @param CHttpRequest $request
     * @return bool
     */
    public function isMainSearchParamChecked($paramName, $value, CHttpRequest $request)
    {
        $data = $request->getQuery($paramName);

        return !empty($data) && in_array($value, $data);
    }

    /**
     * @return array
     */
    public function getMainSearchParams()
    {
        return [
            self::MAIN_SEARCH_PARAM_CATEGORY => 'category_id',
            self::MAIN_SEARCH_PARAM_PRODUCER => 'producer_id'
        ];
    }

    /**
     * @param Attribute $attribute
     * @param null $mode
     * @return null|string
     */
    public function getFieldName(Attribute $attribute, $mode = null)
    {
        $type = (int)$attribute->type;

        if ($type === Attribute::TYPE_SHORT_TEXT) {
            return sprintf($this->stringTemplate, $attribute->name);
        }

        if ($type === Attribute::TYPE_CHECKBOX) {
            return sprintf($this->checkboxTemplate, $attribute->name);
        }

        if ($type === Attribute::TYPE_NUMBER) {
            return sprintf($this->numberTemplate, $attribute->name, $mode);
        }

        return null;
    }

    /**
     * @param Attribute $attribute
     * @param null $mode
     * @return mixed
     */
    public function getFieldValue(Attribute $attribute, $mode = null)
    {
        if(null !== $mode) {
            $data = Yii::app()->getRequest()->getParam($attribute->name);
            return is_array($data) && array_key_exists($mode, $data) ? $data[$mode] : null;
        }

        return Yii::app()->getRequest()->getParam($this->getFieldName($attribute, $mode), null);
    }

    /**
     * @param Attribute $attribute
     * @param null $value
     * @return bool
     */
    public function isFieldChecked(Attribute $attribute, $value = null)
    {
        return Yii::app()->getRequest()->getParam($this->getFieldName($attribute), -1) == $value;
    }


    /**
     * @param AttributeOption $option
     * @return null|string
     */
    public function getDropdownOptionName(AttributeOption $option)
    {
        if ((int)$option->parent->type === Attribute::TYPE_DROPDOWN) {
            return sprintf($this->dropdownTemplate, $option->parent->name, $option->id);
        }

        return null;
    }

    /**
     * @param AttributeOption $option
     * @param mixed $value
     * @return mixed
     */
    public function getIsDropdownOptionChecked(AttributeOption $option, $value)
    {
        $data = Yii::app()->getRequest()->getQuery($option->parent->name, false);

        return is_array($data) && in_array($value, $data);
    }

    /**
     * @param CHttpRequest $request
     * @param array $append
     * @return array|mixed
     */
    public function getMainAttributesForSearchFromQuery(CHttpRequest $request, array $append = [])
    {
        $result = [];

        foreach ($this->getMainSearchParams() as $param => $field) {
            if ($request->getQuery($param)) {
                $result[$param] = $request->getQuery($param);
            }
        }

        if (!empty($append)) {
            $result = CMap::mergeArray($append, $result);
        }

        return $result;
    }


    /**
     * @param CHttpRequest $request
     * @return array
     */
    public function getEavAttributesForSearchFromQuery(CHttpRequest $request)
    {
        $result = $params = [];

        $attributes = Attribute::model()->cache(Yii::app()->getModule('yupe')->coreCacheTime)->findAll(
            ['select' => ['name']]
        );

        foreach ($attributes as $attribute) {

            if ($request->getQuery($attribute->name)) {

                $searchParams = $request->getQuery($attribute->name);

                if (!is_array($searchParams)) {
                    $result[$attribute->name] = $searchParams;
                    continue;
                }

                $isFrom = array_key_exists('from', $searchParams);
                $isTo = array_key_exists('to', $searchParams);

                if (false === $isFrom && false === $isTo) {
                    $result[$attribute->name] = $searchParams;
                    continue;
                }

                if (true === $isFrom && !empty($searchParams['from'])) {
                    $result[] = ['>=', $attribute->name, (float)$searchParams['from']];
                }

                if (true === $isTo && !empty($searchParams['to'])) {
                    $result[] = ['<=', $attribute->name, (float)$searchParams['to']];
                }

            }
        }

        return $result;
    }
}
