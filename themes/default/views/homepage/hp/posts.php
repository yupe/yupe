<?php $this->breadcrumbs = [Yii::t('HomepageModule.homepage', 'Records')]; ?>

<?php $this->widget(
    'bootstrap.widgets.TbListView',
    [
        'dataProvider' => $dataProvider,
        'itemView'     => '_post',
        'template'     => "{items}\n{pager}",
    ]
); ?>
