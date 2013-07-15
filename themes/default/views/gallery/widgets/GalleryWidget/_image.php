<li class="span4">
    <div class="thumbnail">
        <?php echo CHtml::image($data->image->getUrl(320), $data->image->alt);?>
        <div class="caption">
            <h3><?php echo $data->image->getName();?></h3>
            <p align="center">
                <?php echo CHtml::link($data->image->alt,array('/gallery/gallery/foto/','id' => $data->image->id));?>
            </p>
        </div>
    </div>
</li>



