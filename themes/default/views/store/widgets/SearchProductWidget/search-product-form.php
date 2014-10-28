<section class="catalog-filter col-sm-12">
    <?php $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        [
            'action' => ['/store/catalog/search'],
            'method' => 'get',
        ]
    )?>
    <div class="input-group">
        <?= $form->textField($searchForm, 'q', ['class' => 'form-control']); ?>
        <?= $form->hiddenField($searchForm, 'category')?>
        <span class="input-group-btn">
                    <button type="submit" class="btn btn-default"><?= Yii::t("StoreModule.catalog", "поиск"); ?> <i
                            class="glyphicon glyphicon-search"></i></button>
                </span>
    </div>
    <?php $this->endWidget(); ?>
</section>
