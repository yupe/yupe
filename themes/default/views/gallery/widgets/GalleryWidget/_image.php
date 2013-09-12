<li class="gallery-thumbnail span3">
    <div class="thumbnail">
        <?php echo CHtml::image(
            $data->image->getUrl(320),
            $data->image->alt,
            array('href' => $data->image->getUrl(), 'class' => 'gallery-image')
        ); ?>
        <div class="caption">
            <p class="text-center">
                <strong><?php echo $data->image->getName(); ?></strong>
            </p>
            <?php echo CHtml::link(
                Yii::t('default', 'Подробнее...'),
                array('/gallery/gallery/foto/', 'id' => $data->image->id),
                array('class' => 'btn btn-primary btn-block')
            ); ?></a>
        </div>
    </div>
</li>


