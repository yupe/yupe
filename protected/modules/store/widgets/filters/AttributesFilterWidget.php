<?php

/**
 * Class AttributesFilterWidget
 */
class AttributesFilterWidget extends \yupe\widgets\YWidget
{
    /**
     * @var
     */
    public $attributes;

    /**
     * @throws Exception
     */
    public function run()
    {
        if ('*' === $this->attributes) {
            $this->attributes = Attribute::model()->with(['options.parent'])->cache($this->cacheTime)->findAll();
        }

        foreach ($this->attributes as $attribute) {

            $model = is_string($attribute) ? Attribute::model()->findByAttributes(['name' => $attribute]) : $attribute;

            if ($model) {
                switch ($model->type) {
                    case Attribute::TYPE_DROPDOWN:
                        $this->widget(
                            'application.modules.store.widgets.filters.DropdownFilterWidget',
                            ['attribute' => $model]
                        );
                        break;
                    case Attribute::TYPE_CHECKBOX:
                        $this->widget(
                            'application.modules.store.widgets.filters.CheckboxFilterWidget',
                            ['attribute' => $model]
                        );
                        break;
                    case Attribute::TYPE_NUMBER:
                        $this->widget(
                            'application.modules.store.widgets.filters.NumberFilterWidget',
                            ['attribute' => $model]
                        );
                        break;
                    case Attribute::TYPE_SHORT_TEXT:
                        $this->widget(
                            'application.modules.store.widgets.filters.TextFilterWidget',
                            ['attribute' => $model]
                        );
                        break;
                }
            }
        }
    }
} 
