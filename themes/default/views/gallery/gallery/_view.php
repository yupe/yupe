<div class="span5 image">
    <?php
    echo CHtml::link(
        '<h2>' . $data->name . '</h2>'
        . CHtml::image($data->previewImage(), $data->name), array(
            '/gallery/gallery/show/',
            'id' => $data->id
        )
    ); ?>
    <?php echo $data->description; ?>
    <p><?php echo Yii::t('image', 'фото: ({imagesCount})', array('{imagesCount}' => $data->imagesCount)); ?></p>
</div>