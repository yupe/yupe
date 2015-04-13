<div class="col-sm-3">
    <div class="gallery-thumbnail">
        <?php echo CHtml::link(
            CHtml::image(
                $data->image->getImageUrl(190, 190),
                $data->image->alt
            ),
            $data->image->getImageUrl(),
            [
                'class' => 'gallery-image',
                'title' => $data->image->description,
                'rel'   => $data->gallery->id
            ]
        ); ?>
        <?php if ($data->image->canChange()) : { ?>
            <div class="image-changes">
                <?php
                // Редактирование:
                echo CHtml::link(
                    '<i class="fa fa-fw fa-pencil"></i>',
                    Yii::app()->createAbsoluteUrl(
                        'image/imageBackend/update',
                        [
                            'id' => $data->image->id
                        ]
                    )
                ); ?>
                <?php
                // Удаление:
                echo CHtml::link(
                    '<i class="fa fa-fw fa-times"></i>',
                    Yii::app()->createAbsoluteUrl(
                        'gallery/galleryBackend/deleteImage',
                        [
                            'id' => $data->image->id
                        ]
                    )
                ); ?>
            </div>
        <?php } endif; ?>
    </div>
</div>
