<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'action' => ['/store/product/search'],
        'method' => 'get',
    ]
) ?>
<?= $form->textField($searchForm, 'q', ['class' => 'search-bar__input']); ?>
<?= $form->hiddenField($searchForm, 'category') ?>
<?php $this->endWidget(); ?>
