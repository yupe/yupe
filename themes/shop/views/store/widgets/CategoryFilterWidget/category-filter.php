<?php if(!empty($categories)):?>
    <div data-collapse="persist" id="filter-category" class="filter-block">
        <div class="filter-block__title"><?= Yii::t('StoreModule.store', 'Categories');?></div>
        <div class="filter-block__body">
            <div class="filter-block__list filter-block__list">
                <?php foreach($categories as $category):?>
                    <div class="filter-block__list-item">
                        <?= CHtml::checkBox('category[]',Yii::app()->attributesFilter->isMainSearchParamChecked(
                            AttributeFilter::MAIN_SEARCH_PARAM_CATEGORY,
                            $category->id,
                            Yii::app()->getRequest()
                        ),['value' => $category->id, 'id' => 'filter-category-' . $category->id, 'class' => 'checkbox']);?>
                        <?= CHtml::label($category->name, 'filter-category-' . $category->id, ['class' => 'checkbox__label']);?>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
<?php endif;?>
