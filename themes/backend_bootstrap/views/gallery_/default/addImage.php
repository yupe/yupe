<h1><?php echo Yii::t('gallery', 'Добавление изображения в галерею');?> <br/>
    "<?php echo $gallery->name;?>"</h1>

<?php $this->renderPartial('_add_foto_form', array('model' => $model)); ?>

