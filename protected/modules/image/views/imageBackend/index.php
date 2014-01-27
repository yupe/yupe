<?php
    $this->breadcrumbs = array(       
        Yii::t('ImageModule.image', 'Images') => array('/image/imageBackend/index'),
        Yii::t('ImageModule.image', 'Management'),
    );

    $this->pageTitle = Yii::t('ImageModule.image', 'Images - manage');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ImageModule.image', 'Image management'), 'url' => array('/image/imageBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ImageModule.image', 'Add image'), 'url' => array('/image/imageBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo ucfirst(Yii::t('ImageModule.image', 'Images')); ?>
        <small><?php echo Yii::t('ImageModule.image', 'management'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('ImageModule.image', 'Find images'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form').submit(function() {
        $.fn.yiiGridView.update('image-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('ImageModule.image', 'This section describes Image management functions'); ?></p>

<?php
$this->widget(
    'yupe\widgets\CustomGridView', array(
        'id'           => 'image-grid',
        'type'         => 'condensed',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            array(
                'name'   => Yii::t('ImageModule.image', 'file'),
                'type'   => 'raw',
                'value'  => 'CHtml::image($data->getUrl(75), $data->alt, array("width" => 75, "height" => 75))',
                'filter' => false
            ),
            array(
                'header' => Yii::t('ImageModule.image', 'Link'),
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->getRawUrl(), $data->getRawUrl())'
            ),
            array(
                'name'   => 'category_id',
                'value'  => '$data->getCategoryName()',
				'filter' => CHtml::activeDropDownList($model, 'category_id', Category::model()->getFormattedList(Yii::app()->getModule('image')->mainCategory), array('encode' => false, 'empty' => ''))
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
            'name',           
            array(
                'class'       => 'bootstrap.widgets.TbButtonColumn',
                'htmlOptions' => array(
                    'style'   => 'width: 60px;'
                ),
            ),
        ),
    )
); ?>