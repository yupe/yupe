<?php
/**
 * Отображение для default/index:
 * 
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/

$this->breadcrumbs = array(   
    Yii::t('GalleryModule.gallery', 'Galleries') => array('/gallery/galleryBackend/index'),
    Yii::t('GalleryModule.gallery', 'Management'),
);

$this->pageTitle = Yii::t('GalleryModule.gallery', 'Galleries - manage');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('GalleryModule.gallery', 'Gallery management'), 'url' => array('/gallery/galleryBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('GalleryModule.gallery', 'Create gallery'), 'url' => array('/gallery/galleryBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('GalleryModule.gallery', 'Galleries'); ?>
        <small><?php echo Yii::t('GalleryModule.gallery', 'management'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('GalleryModule.gallery', 'Find galleries'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript(
    'search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('gallery-grid', {
            data: $(this).serialize()
        });
        return false;
    });"
);
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('GalleryModule.gallery', 'This section describes image gallery management'); ?></p>

<?php $this->widget(
    'yupe\widgets\CustomGridView', array(
        'id'           => 'gallery-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            array(
                'header' => '',
                'value'  => 'CHtml::image($data->previewImage(), $data->name, array("width" => 100,"height" => 75))',
                'type'   => 'html'
            ),
            array(
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name'  => 'name',
                'editable' => array(
                    'url' => $this->createUrl('/gallery/galleryBackend/inline'),
                    'mode' => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                )
            ),
            array(
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name'  => 'description',
                'value' => 'strip_tags($data->description)',
                'editable' => array(
                    'url' => $this->createUrl('/gallery/galleryBackend/inline'),
                    'mode' => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                )
            ),
            array(
                'class'  => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'  => $this->createUrl('/gallery/galleryBackend/inline'),
                    'mode' => 'popup',
                    'type' => 'select',
                    'source' => $model->getStatusList(),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'name'   => 'status',
                'type'   => 'raw',
                'value'  => '$data->getStatus()',
                'filter' => $model->getStatusList()
            ),
            array(
                'name'   => 'owner',
                'filter' => $model->getUsersList(),
                'value'  => '$data->ownerName',
            ),
            array(
                'name'   => 'imagesCount',
                'value'  => 'CHtml::link($data->imagesCount, array("/gallery/gallery/images/", "id" => $data->id))',
                'type'   => 'raw',
                'filter' => false
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{images}{update}{delete}',
                'buttons'  => array(
                    'images' => array(
                        'icon'     => 'picture',
                        'label'    => Yii::t('GalleryModule.gallery', 'Gallery images'),
                        'url'      => 'array("/gallery/galleryBackend/images", "id" => $data->id)',
                    ),
                ),
                'htmlOptions' => array(
                    'style'   => 'width: 60px; text-align: right;'
                )
            ),
        ),
    )
); ?>