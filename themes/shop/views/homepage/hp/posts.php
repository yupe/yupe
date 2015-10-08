<?php $this->breadcrumbs = [Yii::t('HomepageModule.homepage', 'Records')]; ?>

<?php $this->widget(
    'zii.widgets.CListView',
    [
        'dataProvider' => $dataProvider,
        'itemView'     => '_post',
        'template'     => "{items}\n{pager}",
    ]
); ?>
