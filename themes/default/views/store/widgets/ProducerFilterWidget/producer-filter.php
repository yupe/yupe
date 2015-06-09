<?php if(!empty($producers)):?>
    <div class="filter-block-checkbox-list">
        <div class="filter-block-header">
            <strong><?= Yii::t('StoreModule.store', 'Producers');?></strong>
        </div>
        <div class="filter-block-body">
            <?php foreach($producers as $producer):?>
                <div class="checkbox">
                    <?= CHtml::checkBox('brand[]',Yii::app()->attributesFilter->isMainSearchParamChecked(AttributeFilter::MAIN_SEARCH_PARAM_PRODUCER, $producer->id, Yii::app()->getRequest()),['value' => $producer->id, 'id' => 'brand_'.$producer->id]);?>
                    <?= CHtml::label($producer->name, 'brand[]');?>
                </div>
            <?php endforeach;?>
        </div>
    </div>
    <hr/>
<?php endif;?>
