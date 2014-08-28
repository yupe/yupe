<?php
/**
 * Отображение для default/index:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/

$this->breadcrumbs = array(
    Yii::t('GalleryModule.gallery', 'Galleries') => array('/gallery/galleryBackend/index'),
    Yii::t('GalleryModule.gallery', 'Management'),
);

$this->pageTitle = Yii::t('GalleryModule.gallery', 'Galleries - manage');

$this->menu = array(
    array(
        'icon'  => 'glyphicon glyphicon-list-alt',
        'label' => Yii::t('GalleryModule.gallery', 'Gallery management'),
        'url'   => array('/gallery/galleryBackend/index')
    ),
    array(
        'icon'  => 'glyphicon glyphicon-plus-sign',
        'label' => Yii::t('GalleryModule.gallery', 'Create gallery'),
        'url'   => array('/gallery/galleryBackend/create')
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('GalleryModule.gallery', 'Galleries'); ?>
        <small><?php echo Yii::t('GalleryModule.gallery', 'management'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="glyphicon glyphicon-search">&nbsp;</i>
        <?php echo Yii::t('GalleryModule.gallery', 'Find galleries'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('gallery-grid', {
            data: $(this).serialize()
        });

        return false;
    });"
    );
    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<p><?php echo Yii::t('GalleryModule.gallery', 'This section describes image gallery management'); ?></p>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'gallery-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            array(
                'header' => '',
                'value'  => 'CHtml::image($data->previewImage(), $data->name, array("width" => 75))',
                'type'   => 'html'
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'name',
                'editable' => array(
                    'url'    => $this->createUrl('/gallery/galleryBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'name', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'description',
                'value'    => 'trim(strip_tags($data->description))',
                'editable' => array(
                    'url'    => $this->createUrl('/gallery/galleryBackend/inline'),
                    'type'   => 'textarea',
                    'title'  => Yii::t(
                            'GalleryModule.gallery',
                            'Select {field}',
                            array('{field}' => mb_strtolower($model->getAttributeLabel('description')))
                        ),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'description', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/gallery/galleryBackend/inline'),
                    'type'   => 'select',
                    'title'  => Yii::t(
                            'GalleryModule.gallery',
                            'Select {field}',
                            array('{field}' => mb_strtolower($model->getAttributeLabel('status')))
                        ),
                    'source' => $model->getStatusList(),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'name'     => 'status',
                'type'     => 'raw',
                'value'    => '$data->getStatus()',
                'filter'   => CHtml::activeDropDownList(
                        $model,
                        'status',
                        $model->getStatusList(),
                        array('class' => 'form-control', 'empty' => '')
                    ),
            ),
            array(
                'name'   => 'owner',
                'filter' => $model->getUsersList(),
                'value'  => '$data->ownerName',
            ),
            array(
                'name'   => 'imagesCount',
                'value'  => 'CHtml::link($data->imagesCount, array("/gallery/galleryBackend/images", "id" => $data->id))',
                'type'   => 'raw',
                'filter' => false
            ),
            array(
                'value' => 'yupe\helpers\Html::label($data->status, $data->getStatus(), [Gallery::STATUS_DRAFT => yupe\helpers\Html::DEF, Gallery::STATUS_PUBLIC => yupe\helpers\Html::SUCCESS])',
                'type'  => 'raw'
            ),
            array(
                'class'    => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{images}{update}{delete}',
                'buttons'  => array(
                    'images' => array(
                        'icon'  => 'picture',
                        'label' => Yii::t('GalleryModule.gallery', 'Gallery images'),
                        'url'   => 'array("/gallery/galleryBackend/images", "id" => $data->id)',
                    ),
                ),
            ),
        ),
    )
); ?>
