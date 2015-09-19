<section class="catalog-filter col-sm-12">
    <?php $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        [
            'action' => ['/store/product/search'],
            'method' => 'get',
        ]
    )?>
    <div class="input-group">
        <?= $form->textField($searchForm, 'q', ['class' => 'form-control']); ?>
        <?= $form->hiddenField($searchForm, 'category')?>
        <span class="input-group-btn">
                    <button type="submit" class="btn btn-default"><?= Yii::t("StoreModule.store", "search"); ?> <i
                            class="glyphicon glyphicon-search"></i></button>
                </span>
    </div>
    <?php $this->endWidget(); ?>
</section>
