<?php
$this->breadcrumbs = [
    Yii::t('ImageModule.image', 'Images') => ['/image/imageBackend/index'],
    Yii::t('ImageModule.image', 'Add'),
];

$this->pageTitle = Yii::t('ImageModule.image', 'Images - add');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('ImageModule.image', 'Image management'),
        'url'   => ['/image/imageBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('ImageModule.image', 'Add image'),
        'url'   => ['/image/imageBackend/create']
    ],
];
?>
<div class="page-header">
    <h1>
        <?=  Yii::t('ImageModule.image', 'Images'); ?>
        <small><?=  Yii::t('ImageModule.image', 'add'); ?></small>
    </h1>
</div>

<?=  $this->renderPartial('_form', ['model' => $model]); ?>
