<?php
    $this->breadcrumbs = array(        
        Yii::t('ImageModule.image', 'Images') => array('/image/imageBackend/index'),
        $model->name,
    );

    $this->pageTitle = Yii::t('ImageModule.image', 'Images - show');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ImageModule.image', 'Image management'), 'url' => array('/image/imageBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ImageModule.image', 'Add image'), 'url' => array('/image/imageBackend/create')),
        array('label' => Yii::t('ImageModule.image', 'Image') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('ImageModule.image', 'Edit image'), 'url' => array(
            '/image/imageBackend/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('ImageModule.image', 'View image'), 'url' => array(
            '/image/imageBackend/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('ImageModule.image', 'Remove image'),'url' => '#', 'linkOptions' => array(
            'submit'  => array('/image/imageBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('ImageModule.image', 'Do you really want to remove image?'),
            'csrf' => true,
        )),
    );
?>
<div class="page-header">
    <h1><?php echo Yii::t('ImageModule.image', 'Show image'); ?><br />
    <small>&laquo;<?php echo $model->name; ?>&raquo;</small></h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
    'data'       => $model,
    'attributes' => array(
        'id',
        'category_id',
        'parent_id',
        'name',
        'description',
         array(
             'name'   => 'file',
             'type'   => 'raw',
             'label'  => Yii::t('ImageModule.image','Link'),
             'value'  => CHtml::link($model->getRawUrl(), $model->getRawUrl()),
         ),
        array(
             'name'  => 'file',
             'type'  => 'raw',
             'value' => CHtml::image($model->getUrl(100), $model->alt),
         ),
        'creation_date',
        array(
            'name'  => 'user_id',
            'value' => $model->userName,
        ),
        'alt',
        array(
            'name'  => 'type',
            'value' => $model->getType(),
        ),
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        )
    ),
)); ?>
