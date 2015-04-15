<?php
$this->title = [Yii::t('CatalogModule.catalog', 'Products'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [Yii::t('CatalogModule.catalog', 'Products')];
?>

<h1><?php echo Yii::t('CatalogModule.catalog', 'Products'); ?></h1>

<?php $this->widget(
    'bootstrap.widgets.TbListView',
    [
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
        'summaryText' => '',
        'enableHistory' => true,
        'cssFile' => false,
        'pager' => [
            'cssFile' => false,
            'htmlOptions' => ['class' => 'pagination'],
            'header' => '',
            'firstPageLabel' => '&lt;&lt;',
            'lastPageLabel' => '&gt;&gt;',
            'nextPageLabel' => '&gt;',
            'prevPageLabel' => '&lt;',
        ],
    ]
); ?>
