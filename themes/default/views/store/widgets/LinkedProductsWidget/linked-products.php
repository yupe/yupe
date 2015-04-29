<?php /* @var $dataProvider CActiveDataProvider */ ?>
<h3>
    <?= Yii::t('StoreModule.product', 'Linked products') ?>
</h3>

<?php $this->widget(
    'zii.widgets.CListView',
    [
        'dataProvider' => $dataProvider,
        'template' => '{items}',
        'itemView' => '_view',
        'cssFile' => false,
        'pager' => false,
    ]
); ?>

