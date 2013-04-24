<?php $this->pageTitle = Yii::t('gallery', 'Галереи изображений!'); ?>

<h1><?php echo Yii::t('gallery', 'Галереи изображений!');?></h1>

<div id="gallery-wrapper">
<?php
$this->widget(
    'zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
    )
); ?>
</div>