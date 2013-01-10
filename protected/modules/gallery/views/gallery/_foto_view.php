<div class="view">
    <a href='<?php echo $this->createUrl('/gallery/gallery/foto', array('id' => $data->image->id)); ?>'>
        <?php echo CHtml::image($data->image->file, $data->image->name, array('width' => 75, 'height' => 75));?>
    </a>
    <br/>
    <b><?php echo Yii::t('GalleryModule.gallery', 'Название'); ?>:</b>
    <?php echo CHtml::link($data->image->name, array('/gallery/gallery/foto', 'id' => $data->image->id)); ?>
    <br/>
    <b><?php echo Yii::t('GalleryModule.gallery', 'Описание'); ?>:</b>
    <?php echo CHtml::encode($data->image->description); ?>
    <br/>
</div>