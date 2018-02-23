<div class="image-wrapper">
    <div class="gallery-thumbnail">
        <?= CHtml::link(
            CHtml::image($image->getImageUrl(190, 190), $image->alt),
            $image->getImageUrl(),
            [
                'class' => 'gallery-image',
                'title' => $image->title,
            ]
        ); ?>
    </div>
    <div class="btn-group btn-group-xs" role="group">
        <?= CHtml::link(
            '<i class="fa fa-fw fa-times"></i>',
            Yii::app()->createAbsoluteUrl('store/productImageBackend/deleteImage', [
                'id' => $image->id,
                'product' => $product->id,
            ]),
            [
                'class' => 'btn btn-danger',
                'data-toggle' => 'tooltip',
                'title' => Yii::t('StoreModule.store', 'Delete'),
            ]
        ); ?>
    </div>
</div>