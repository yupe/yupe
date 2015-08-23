<?php
$this->title = [Yii::t('NewsModule.news', 'News'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [Yii::t('NewsModule.news', 'News')];
?>

<h1>Новости</h1>

<?php $this->widget(
    'bootstrap.widgets.TbListView',
    [
        'dataProvider' => $dataProvider,
        'itemView'     => '_item',
    ]
); ?>
