<?php echo CHtml::link($data->name, array('/gallery/default/show/', 'id' => $data->id)); ?> - <?php echo $data->description; ?>
<?php echo Yii::t('image', 'фото: '); ?>(<?php echo $data->imagesCount; ?>)
<br/><br/>