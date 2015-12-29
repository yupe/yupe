<?php

/**
 * Class AttributeFilter
 */
class AttributeFilter extends CApplicationComponent
{
    /**
     *
     */
    const MAIN_SEARCH_PARAM_PRODUCER = 'brand';
    /**
     *
     */
    const MAIN_SEARCH_PARAM_CATEGORY = 'category';

    /**
     *
     */
    const MAIN_SEARCH_PARAM_NAME = 'name';

    /**
     *
     */
    const MAIN_SEARCH_PARAM_PRICE = 'price';

    /**
     *
     */
    const MAIN_SEARCH_QUERY_NAME = 'q';

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
     * @param $name
     * @param null $suffix
     * @param CHttpRequest $request
     * @return mixed|null
     */
    public function getMainSearchParamsValue($name, $suffix = null, CHttpRequest $request)
    {
        $data = $request->getQuery($name);

        if (empty($data)) {
            return null;
        }

        if (null === $suffix && !is_array($data)) {
            return $data;
        }

        if (is_array($data) && null !== $suffix) {
            return isset($data[$suffix]) ? $data[$suffix] : null;
        }

        return null;
    }

    /**
     * @return array
     */
    public function getMainSearchParams()
    {
        return [
            self::MAIN_SEARCH_PARAM_CATEGORY => 'category_id',
            self::MAIN_SEARCH_PARAM_PRODUCER => 'producer_id',
            self::MAIN_SEARCH_PARAM_PRICE => 'price',
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
        if (null !== $mode) {
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
                if (is_array($result[$param])) {
                    if (isset($result[$param]['to']) && null == $result[$param]['to']) {
                        unset($result[$param]['to']);
                    }
                    if (isset($result[$param]['from']) && null == $result[$param]['from']) {
                        unset($result[$param]['from']);
                    }
                }
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
    public function getTypeAttributesForSearchFromQuery(CHttpRequest $request)
    {
        $attributes = Yii::app()->getCache()->get('Store::filter::attributes');

        if (false === $attributes) {

            $attributes = [];

            $models = Attribute::model()->findAll(
                ['select' => ['name', 'id', 'type']]
            );

            foreach ($models as $model) {
                $attributes[$model->name] = $model;
            }

            Yii::app()->getCache()->set('Store::filter::attributes', $attributes);
        }

        $result = [];

        $attributeValue = new AttributeValue();

        foreach ($attributes as $name => $attribute) {

            $searchParams = $request->getQuery($attribute->name);

            //пропускаем пустые значения
            if (null === $searchParams) {
                continue;
            }

            if (is_array($searchParams)) {
                if (isset($searchParams['from']) && null == $searchParams['from']) {
                    unset($searchParams['from']);
                }
                if (isset($searchParams['to']) && null == $searchParams['to']) {
                    unset($searchParams['to']);
                }
                if (empty($searchParams)) {
                    continue;
                }
            }

            $result[$attribute->name] = [
                'value' => $searchParams,
                'attribute_id' => (int)$attribute->id,
                'column' => $attributeValue->column($attribute->type),
            ];
        }

        return $result;
    }
}
