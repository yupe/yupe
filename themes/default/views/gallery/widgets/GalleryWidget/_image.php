<li class="gallery-thumbnail col-sm-3">
    <div class="thumbnail">
        <?= CHtml::image(
            $data->image->getImageUrl(90, 90),
            $data->image->alt,
            ['title' => $data->image->alt, 'href' => $data->image->getImageUrl(), 'class' => 'gallery-image']
        ); ?>
        <div class="caption">
            <p class="text-center">
                <strong><?= $data->image->getName(); ?></strong>
            </p>
            <?= CHtml::link(
                Yii::t('GalleryModule.gallery', 'More...'),
                $data->image->getUrl(),
                ['class' => 'btn btn-success btn-block']
            ); ?>
        </div>
    </div>
</li>
