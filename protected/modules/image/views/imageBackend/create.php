<?php
$this->breadcrumbs = array(
    Yii::t('ImageModule.image', 'Images') => array('/image/imageBackend/index'),
    Yii::t('ImageModule.image', 'Add'),
);

$this->pageTitle = Yii::t('ImageModule.image', 'Images - add');

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
        <?php echo Yii::t('ImageModule.image', 'Images'); ?>
        <small><?php echo Yii::t('ImageModule.image', 'add'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
