<section class="catalog-filter col-sm-12">
    <?php $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        [
            'action' => ['/store/product/index'],
            'method' => 'GET',
        ]
    ) ?>
    <div class="input-group">
        <?= CHtml::textField(
            AttributeFilter::MAIN_SEARCH_QUERY_NAME,
            CHtml::encode(Yii::app()->getRequest()->getQuery(AttributeFilter::MAIN_SEARCH_QUERY_NAME)),
            ['class' => 'form-control']
        ); ?>

        <span class="input-group-btn">
            <button type="submit" class="btn btn-default">
                <?= Yii::t("StoreModule.store", "search"); ?>
                <i class="glyphicon glyphicon-search"></i>
            </button>
        </span>
    </div>
    <?php $this->endWidget(); ?>
</section>
