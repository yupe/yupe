<div class="view">

    <a href='<?php echo $this->createUrl('/contest/contest/foto/', array('id' => $data->image->id));?>'><?php echo CHtml::image($data->image->file, $data->image->name, array('width' => 75, 'height' => 75));?></a>
    <br/>
    <b><?php echo Yii::t('contest', 'Название'); ?>:</b>
    <?php echo CHtml::link($data->image->name, array('/contest/contest/foto/', 'id' => $data->image->id)); ?>
    <br/>
    <b><?php echo Yii::t('contest', 'Описание'); ?>:</b>
    <?php echo CHtml::encode($data->image->description); ?>
    <br/>
</div>