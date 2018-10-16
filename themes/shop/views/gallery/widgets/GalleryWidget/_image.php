<?php
$url = Yii::app()->createUrl('/gallery/gallery/image', ['id' => $data->image->id]);
?>
<div class="catalog__item gallery-thumbnail">
    <article class="product-vertical">
        <div class="product-vertical__thumbnail">
                <?= CHtml::image(
                    $data->image->getImageUrl(300, 300),
                    $data->image->alt,
                    ['title' => $data->image->alt, 'href' => $data->image->getImageUrl(), 'class' => 'gallery-image']
                ); ?>
        </div>
        <div class="product-vertical__content">
            <a href="<?= $url ?>" class="product-vertical__title"><?= $data->image->getName(); ?></a>
        </div>
        <div class="product-vertical__extra">
            <a href="<?= $url ?>" class="btn btn_wide btn_primary"><?= Yii::t('GalleryModule.gallery', 'More...') ?></a>
        </div>
    </article>
</div>
