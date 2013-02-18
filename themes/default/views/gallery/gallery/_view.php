<?php echo CHtml::link($data->name, array('/gallery/gallery/show/', 'id' => $data->id)); ?> - <?php echo $data->description; ?>
<p><?php echo Yii::t('image', 'фото: '); ?>(<?php echo $data->imagesCount; ?>)</p>
