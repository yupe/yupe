<?php
/**
 * Отображение для gallery/_item:
 *
 * @category YupeView
 * @package  YupeCMS
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 *
 * @var $this GalleryController
 * @var $data Gallery
 **/
?>
<div class="catalog__item">
    <article class="product-vertical">
        <a href="<?= $data->getUrl() ?>">
            <div class="product-vertical__thumbnail">
                <?= CHtml::image($data->previewImage(300, 300), $data->name, ['class' => 'thumbnail media-object']) ?>
            </div>
        </a>
        <div class="product-vertical__extra">

            <h3 class="media-heading">
                <?= CHtml::link(CHtml::encode($data->name), $data->getUrl()); ?>
            </h3>

            <?= $data->description; ?>

            <div class="well well-sm">
                <?php if ($data->imagesCount): ?>
                    <ul class="list-inline">
                        <li>
                            <?= Yii::t('GalleryModule.gallery', 'Messages summary:'); ?> <b><?= $data->imagesCount; ?></b>
                        </li>
                        <li>
                            <i class="glyphicon glyphicon-calendar"></i> <?= Yii::app()->dateFormatter->format(
                                'dd MMMM yyyy г., hh:mm',
                                $data->lastUpdated
                            ); ?>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>

        </div>
    </article>
</div>
