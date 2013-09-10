<div class="gallery-list">
<?php $this->pageTitle = Yii::t('default', 'Галереи изображений'); ?>

<?php $this->breadcrumbs = array(Yii::t('default', 'Галереи изображений'));?>

<h1 class="page-header"><?php echo Yii::t('default', 'Галереи изображений');?></h1>

<?php
$this->widget(
    'bootstrap.widgets.TbListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
    )
); ?>
</div>

