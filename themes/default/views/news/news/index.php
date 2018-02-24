<?php
$this->title = Yii::app()->getModule('news')->metaTitle ?: Yii::t('NewsModule.news', 'News');
$this->description = Yii::app()->getModule('news')->metaDescription;
$this->keywords = Yii::app()->getModule('news')->metaKeyWords;

$this->breadcrumbs = [Yii::t('NewsModule.news', 'News')];
?>

<h1><?= Yii::t('NewsModule.news', 'News') ?></h1>

<?php $this->widget(
    'bootstrap.widgets.TbListView',
    [
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
    ]
); ?>
