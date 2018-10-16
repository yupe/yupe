<?php /* @var $dataProvider CActiveDataProvider */ ?>
<?php if ($dataProvider->getTotalItemCount()): ?>
    <hr>
    <h3>
        <?= Yii::t('StoreModule.store', 'Linked products') ?>
    </h3>

    <?php $this->widget(
        'zii.widgets.CListView',
        [
            'dataProvider' => $dataProvider,
            'template' => '{items}',
            'itemView' => '_item',
            'cssFile' => false,
            'pager' => false,
        ]
    ); ?>

<?php endif; ?>