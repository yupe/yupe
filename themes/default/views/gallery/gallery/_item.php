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
<div class="media">
    <?= CHtml::link(
        CHtml::image($data->previewImage(300, 300), $data->name, ['class' => 'thumbnail media-object']),
        $data->getUrl(),
        ['class' => 'pull-left']
    ); ?>

    <div class="media-body">

        <h3 class="media-heading">
            <?= CHtml::link(CHtml::encode($data->name), $data->getUrl()); ?>
        </h3>

        <?= $data->description; ?>

        <div class="well well-sm">
            <?php if ($data->imagesCount): ?>
                <ul class="list-inline">
                    <li>
                        <?= Yii::t('GalleryModule.gallery', 'Messages summary:'); ?> <span
                            class="badge alert-info"><?= $data->imagesCount; ?></span>
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
</div>
