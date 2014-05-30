<li class="gallery-thumbnail span3">
    <div class="thumbnail">
        <?php echo CHtml::image(
            $data->image->getUrl(90, 90),
            $data->image->alt,
            array('title' => $data->image->alt,'href' => $data->image->getUrl(), 'class' => 'gallery-image')
        ); ?>
        <div class="caption">
            <p class="text-center">
                <strong><?php echo $data->image->getName(); ?></strong>
            </p>
            <?php echo CHtml::link(
                Yii::t('GalleryModule.gallery', 'More...'),
                array('/gallery/gallery/image/', 'id' => $data->image->id),
                array('class' => 'btn btn-success btn-block')
            ); ?></a>
        </div>
    </div>
</li>


