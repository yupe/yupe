<div class="filter-block">
    <div class="filter-block__title">
        <div class="filter-block__range">
            <span class="filter-input__box">
            <?= CHtml::textField(
                AttributeFilter::MAIN_SEARCH_QUERY_NAME,
                CHtml::encode(Yii::app()->getRequest()->getQuery(AttributeFilter::MAIN_SEARCH_QUERY_NAME)),
                [
                    'class' => 'filter-input__control',
                    'placeholder' => 'Название товара'
                ]
            ) ?>
                </span>
        </div>
    </div>
</div>