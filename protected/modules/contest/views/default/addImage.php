<h1><?php echo Yii::t('contest', 'Добавление изображения в конкурс');?> <br/>
    "<?php echo $contest->name;?>"</h1>

<?php $this->renderPartial('_add_foto_form', array('model' => $model)); ?>

