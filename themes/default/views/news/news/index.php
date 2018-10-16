<?php
$this->pageTitle = Yii::t('NewsModule.news', 'News');
$this->breadcrumbs = [Yii::t('NewsModule.news', 'News')];
?>

<h1>Новости</h1>

<?php $this->widget(
    'zii.widgets.CListView',
    [
        'dataProvider' => $dataProvider,
        'itemView'     => '_view',
    ]
); ?>
