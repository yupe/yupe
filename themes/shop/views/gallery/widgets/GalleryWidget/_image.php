<div class="catalog__item gallery-thumbnail">
    <article class="product-vertical">
        <div class="product-vertical__thumbnail">
<!--            <a href="--><?//= $data->image->getUrl() ?><!--">-->
                <?= CHtml::image(
                    $data->image->getImageUrl(300, 300),
                    $data->image->alt,
                    ['title' => $data->image->alt, 'href' => $data->image->getImageUrl(), 'class' => 'gallery-image']
                ); ?>
<!--            </a>-->
        </div>
        <div class="product-vertical__content">
            <a href="<?= $data->image->getUrl() ?>" class="product-vertical__title"><?= $data->image->getName(); ?></a>
        </div>
        <div class="product-vertical__extra">
            <a href="<?= $data->image->getUrl() ?>" class="btn btn_wide btn_primary"><?= Yii::t('GalleryModule.gallery', 'More...') ?></a>
        </div>
    </article>
</div>
