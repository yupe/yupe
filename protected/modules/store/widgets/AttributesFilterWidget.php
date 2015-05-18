<?php

class AttributesFilterWidget extends \yupe\widgets\YWidget
{
    public $attributes;

    public function run()
    {
        foreach ($this->attributes as $name) {
            $model = Attribute::model()->findByAttributes(['name' => $name]);
            if ($model) {
                switch ($model->type) {
                    case Attribute::TYPE_DROPDOWN:
                        $this->widget('application.modules.store.widgets.DropdownFilterWidget', ['attribute' => $model]);
                        break;
                    case Attribute::TYPE_CHECKBOX:
                        $this->widget('application.modules.store.widgets.CheckboxFilterWidget', ['attribute' => $model]);
                        break;
                    case Attribute::TYPE_NUMBER:
                        $this->widget('application.modules.store.widgets.NumberFilterWidget', ['attribute' => $model]);
                        break;
                }
            }
        }
    }
} 
