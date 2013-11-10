<li class="gallery-thumbnail span3">
    <?php if ($data->image->canChange()) : ?>
        <div class="image-changes">
            <?php
            // Редактирование:
            echo CHtml::link(
                '<i class="icon-pencil"></i>',
                Yii::app()->createAbsoluteUrl(
                    'image/imageBackend/update',
                    array(
                        'id' => $data->image->id
                    )
                )
            ); ?>
            <?php
            // Удаление:
            echo CHtml::link(
                '<i class="icon-remove"></i>',
                Yii::app()->createAbsoluteUrl(
                    'gallery/galleryBackend/deleteImage',
                    array(
                        'id' => $data->image->id
                    )
                )
            ); ?>
        </div>
    <?php endif; ?>
    <?php echo CHtml::link(
        CHtml::image(
            $data->image->getUrl(190),
            $data->image->alt
        ),
        $data->image->getUrl(),
        array(
            'class' => 'gallery-image',
            'title' => $data->image->description,
            'rel' => $data->gallery->id
        )
    ); ?>
</li>