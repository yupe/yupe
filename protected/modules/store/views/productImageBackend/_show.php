<?php
$mainAssets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('gallery.views.assets'));
Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/gallery.css');

$this->widget('gallery.extensions.colorbox.ColorBox', [
    'target' => '.gallery-image',
    'config' => [],
]);
?>

<div id="gallery-wrapper">
    <div class="row product-thumbnails thumbnails">
        <?php if (count($product->images) > 0): ?>
            <?php
            foreach ($product->images as $image) {
                $this->renderPartial('_image', [
                    'image' => $image,
                    'product' => $product,
                ]);
            }
            ?>
        <?php else: ?>
            <div class="image-wrapper">
                <?= Yii::t('StoreModule.store', 'Images not found'); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
