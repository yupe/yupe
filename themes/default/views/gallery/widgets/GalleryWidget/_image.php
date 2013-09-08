<li class="span4">
    <div class="thumbnail">
        <?php echo CHtml::image($data->image->getUrl(320), $data->image->alt, array('width' => 320, 'height' => 200,'href' => $data->image->getUrl(),'class' => 'gallery-image')); ?>
        <div class="caption">
            <h3><?php echo $data->image->getName(); ?></h3>
            <p><?php echo $data->image->alt; ?></p>
            <p align="center">
                <?php echo CHtml::link(Yii::t('default','Подробнее...'),array('/gallery/gallery/foto/','id' => $data->image->id),array('class' => 'btn btn-primary btn-block'));?></a>
            </p>
        </div>
    </div>
</li>