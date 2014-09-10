<?php
/**
 * Отображение для gallery/_view:
 *
 * @category YupeView
 * @package  YupeCMS
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
?>
<div class="media">
    <?php echo CHtml::link(
        CHtml::image($data->previewImage(300, 300), $data->name, array('class' => 'thumbnail media-object')),
        array('/gallery/gallery/show/', 'id' => $data->id),
        array('class' => 'pull-left')
    ); ?>

    <div class="media-body">

        <h3 class="media-heading">
            <?php echo CHtml::link(CHtml::encode($data->name), array('/gallery/gallery/show/', 'id' => $data->id)); ?>
        </h3>

        <?php echo $data->description; ?>

        <div class="well well-sm">
            <?php if ($data->imagesCount): ?>
                <ul class="list-inline">
                    <li>
                        <?php echo Yii::t('GalleryModule.gallery', 'Messages summary:'); ?> <span
                            class="badge alert-info"><?php echo $data->imagesCount; ?></span>
                    </li>
                    <li>
                        <i class="glyphicon glyphicon-calendar"></i> <?php echo Yii::app()->dateFormatter->format(
                            'dd MMMM yyyy г., hh:mm',
                            $data->lastUpdated
                        ); ?>
                    </li>
                </ul>
            <?php endif; ?>
        </div>

    </div>
</div>
