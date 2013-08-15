<div class="span4">
    <div class="row">
        <div class="span4">
            <h1>
                <small><?php echo $data->image->getName(); ?></small>
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="span4">
            <?php echo CHtml::image($data->image->getUrl(320), $data->image->alt, array('href' => $data->image->getUrl(),'class' => 'gallery-image')); ?>
        </div>
    </div>
</div>


