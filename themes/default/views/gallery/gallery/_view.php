<div class="media">
    <?php echo CHtml::link(
        CHtml::image($data->previewImage(), $data->name, array('class' => 'thumbnail media-object')),
        array('/gallery/gallery/show/', 'id' => $data->id),
        array('class' => 'pull-left')
    ); ?>
    <div class="media-body">
        <h3 class="media-heading">
            <?php echo CHtml::link(CHtml::encode($data->name), array('/gallery/gallery/show/', 'id' => $data->id)); ?>
        </h3>
        <?php echo $data->description; ?>
        <div class="well well-small">
            <?php if ($data->imagesCount): ?>
                <ul class="inline">
                    <li>
                        Всего изображений: <span class="badge badge-info"><?php echo $data->imagesCount; ?></span>
                    </li>
                    <li>
                        <i class="icon-calendar"></i> <?php echo Yii::app()->dateFormatter->format(
                            'dd MMMM yyyy г., hh:mm',
                            $data->lastUpdated
                        ); ?>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>