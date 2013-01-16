<h1><?php echo Yii::t('GalleryModule.gallery', 'Галереи изображений'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView'     => '_view',
)); ?>
