<?php $this->breadcrumbs = [Yii::t('default', 'Records')]; ?>

<?php $this->widget(
    'bootstrap.widgets.TbListView',
    [
        'dataProvider' => $dataProvider,
        'itemView'     => '_view',
        'template'     => "{items}\n{pager}",
    ]
); ?>
