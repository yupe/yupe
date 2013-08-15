<div class="row">
    <div class="span8">
        <h4><strong><?php echo CHtml::link(CHtml::encode($data->name), array('/gallery/gallery/show/', 'id' => $data->id)); ?></strong></h4>
    </div>
</div>
<div class="row">
    <div class="span2">
        <a href="<?php echo Yii::app()->createUrl('/gallery/gallery/show/', array('id' => $data->id));?>">
            <?php echo CHtml::link(CHtml::image($data->previewImage(), $data->name), array('/gallery/gallery/show/', 'id' => $data->id)); ?>
        </a>
    </div>
    <div class="span6">
        <p> <?php echo $data->description; ?></p>
    </div>
</div>
<div class="row">
    <div class="span8">
        <p>            
            <i class="icon-picture"></i> <?php echo CHtml::link($data->imagesCount, array('/gallery/gallery/show/', 'id' => $data->id)); ?>
        </p>
    </div>
</div>
<hr>