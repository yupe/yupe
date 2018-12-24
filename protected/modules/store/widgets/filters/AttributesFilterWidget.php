<?php
Yii::import('application.modules.store.components.repository.AttributesRepository');

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
     * @var
     */
    public $category;

    /**
     * @var AttributesRepository
     */
    protected $attributesRepository;


    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->attributesRepository = new AttributesRepository();
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        if ($this->category) {
            $this->attributes = $this->attributesRepository->getForCategory($this->category);
        }

        if ('*' === $this->attributes) {
            $this->attributes = Attribute::model()->with(['options.parent', 'group'])->findAll([
                'condition' => 't.is_filter = 1',
                'order' => 'group.position ASC, t.sort ASC',
            ]);
        }

        foreach ($this->attributes as $attribute) {

            $model = is_string($attribute) ? Attribute::model()->findByAttributes([
                'name' => $attribute,
                'is_filter' => \yupe\components\WebModule::CHOICE_YES,
            ]) : $attribute;

            if ($model) {
                switch ($model->type) {
                    case Attribute::TYPE_DROPDOWN:
                        $this->widget(
                            'application.modules.store.widgets.filters.DropdownFilterWidget',
                            ['attribute' => $model]
                        );
                        break;
                    case Attribute::TYPE_CHECKBOX_LIST:
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
