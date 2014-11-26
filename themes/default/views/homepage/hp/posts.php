<?php $this->breadcrumbs = [Yii::t('HomepageModule.homepage', 'Records')]; ?>

<?php $this->widget(
    'bootstrap.widgets.TbListView',
    [
        'dataProvider' => $dataProvider,
        'itemView'     => '_view',
        'template'     => "{items}\n{pager}",
    ]
); ?>
