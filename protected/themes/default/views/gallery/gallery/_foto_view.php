<div class="view">
    <a href='<?php echo $this->createUrl('/gallery/gallery/foto/', array('id' => $data->image->id));?>'><?php echo CHtml::image($data->image->getUrl(), $data->image->name, array('width' => 100));?></a>
    <br/>
    <b><?php echo Yii::t('gallery', 'Название'); ?>:</b>
    <?php echo CHtml::link($data->image->name, array('/gallery/gallery/foto/', 'id' => $data->image->id)); ?>
    <br/>
    <b><?php echo Yii::t('gallery', 'Описание'); ?>:</b>
    <?php echo CHtml::encode($data->image->description); ?>
    <br/>
</div>
