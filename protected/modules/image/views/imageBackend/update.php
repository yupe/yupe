<?php
$this->breadcrumbs = [
    Yii::t('ImageModule.image', 'Images') => ['/image/imageBackend/index'],
    $model->name                          => ['/image/imageBackend/view', 'id' => $model->id],
    Yii::t('ImageModule.image', 'Edit'),
];

$this->pageTitle = Yii::t('ImageModule.image', 'Images - edit');

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
    ['label' => Yii::t('ImageModule.image', 'Image') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('ImageModule.image', 'Edit image'),
        'url'   => [
            '/image/imageBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('ImageModule.image', 'View image'),
        'url'   => [
            '/image/imageBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('ImageModule.image', 'Remove image'),
        'url'         => '#',
        'linkOptions' => [
            'submit'  => ['/image/imageBackend/delete', 'id' => $model->id],
            'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('ImageModule.image', 'Do you really want to remove image?'),
            'csrf'    => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1><?php echo Yii::t('ImageModule.image', 'Change image'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
