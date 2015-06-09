<?php if(!empty($categories)):?>
    <div class="filter-block-checkbox-list">
        <div class="filter-block-header">
            <strong><?= Yii::t('StoreModule.store', 'Categories');?></strong>
        </div>
        <div class="filter-block-body">
            <?php foreach($categories as $category):?>
                <div class="checkbox">
                    <?= CHtml::checkBox('category[]',Yii::app()->attributesFilter->isMainSearchParamChecked(AttributeFilter::MAIN_SEARCH_PARAM_CATEGORY, $category->id, Yii::app()->getRequest()),['value' => $category->id, 'id' => 'category_'. $category->id]);?>
                    <?= CHtml::label($category->name, 'category[]');?>
                </div>
            <?php endforeach;?>
        </div>
    </div>
    <hr/>
<?php endif;?>
