<?php
$this->breadcrumbs = array(
    Yii::t('ImageModule.image', 'Images') => array('/image/imageBackend/index'),
    Yii::t('ImageModule.image', 'Management'),
);

$this->pageTitle = Yii::t('ImageModule.image', 'Images - manage');

$this->menu = array(
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('ImageModule.image', 'Image management'),
        'url'   => array('/image/imageBackend/index')
    ),
    array(
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('ImageModule.image', 'Add image'),
        'url'   => array('/image/imageBackend/create')
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo ucfirst(Yii::t('ImageModule.image', 'Images')); ?>
        <small><?php echo Yii::t('ImageModule.image', 'management'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('ImageModule.image', 'Find images'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="search-form collapse out">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('image-grid', {
            data: $(this).serialize()
        });

        return false;
    });
"
    );
    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'image-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            array(
                'name'   => Yii::t('ImageModule.image', 'file'),
                'type'   => 'raw',
                'value'  => 'CHtml::image($data->getImageUrl(75, 75), $data->alt, array("width" => 75, "height" => 75))',
                'filter' => false
            ),
            'name',
            array(
                'header' => Yii::t('ImageModule.image', 'Link'),
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->getImageUrl(), $data->getImageUrl())'
            ),
            array(
                'name'   => 'category_id',
                'value'  => '$data->getCategoryName()',
                'filter' => CHtml::activeDropDownList(
                        $model,
                        'category_id',
                        Category::model()->getFormattedList(Yii::app()->getModule('image')->mainCategory),
                        array('encode' => false, 'empty' => '', 'class' => 'form-control')
                    )
            ),
            array(
                'name'   => 'galleryId',
                'header' => Yii::t('ImageModule.image', 'Gallery'),
                'type'   => 'raw',
                'filter' => $model->galleryList(),
                'value'  => '$data->galleryName === null
                            ? "---"
                            : CHtml::link(
                                $data->gallery->name,
                                array("/gallery/galleryBackend/images", "id" => $data->gallery->id)
                            )',
            ),
            array(
                'class' => 'yupe\widgets\CustomButtonColumn',
            ),
        ),
    )
); ?>
